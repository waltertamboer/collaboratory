<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Controller;

use CollabApplication\Form\DeleteForm;
use CollabScm\Entity\Repository;
use CollabScm\Entity\RepositoryTeam;
use CollabScm\Form\RepositoryForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RepositoryController extends AbstractActionController
{
    private $projectService;
    private $teamService;
    private $repositoryService;
    private $repositoryTeamService;

    private function getProjectService()
    {
        if ($this->projectService === null) {
            $this->projectService = $this->getServiceLocator()->get('project.service');
        }
        return $this->projectService;
    }

    private function getTeamService()
    {
        if ($this->teamService === null) {
            $this->teamService = $this->getServiceLocator()->get('team.service');
        }
        return $this->teamService;
    }

    private function getRepositoryService()
    {
        if ($this->repositoryService === null) {
            $this->repositoryService = $this->getServiceLocator()->get('CollabScm\Service\Repository');
        }
        return $this->repositoryService;
    }

    private function getRepositoryTeamService()
    {
        if ($this->repositoryTeamService === null) {
            $this->repositoryTeamService = $this->getServiceLocator()->get('CollabScm\Service\RepositoryTeam');
        }
        return $this->repositoryTeamService;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariable('projects', $this->getProjectService()->getAll());
        return $viewModel;
    }

    public function createAction()
    {
        $project = $this->getProjectService()->getById($this->params('project'));
        if (!$project) {
            return $this->redirect()->toRoute('project/overview');
        }

        if (!$this->userAccess('repository_create')) {
            return $this->redirect()->toRoute('project/view', array(
                'id' => $project->getId()
            ));
        }

        $uniqueNameValidator = $this->getServiceLocator()->create('CollabScm\Validator\RepositoryName');
        $form = new RepositoryForm($uniqueNameValidator);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $repository = new Repository();

            $form->bind($repository);
            $form->setData($request->getPost());

            if ($form->isValid()) {
				$repository->setProject($project);

                // Create the repository:
                $this->getRepositoryService()->persist($repository);

                // Create the teams manually:
                $teamService = $this->getTeamService();
                foreach ($request->getPost('teams') as $teamData) {
                    if ($teamData['id']) {
                        $repositoryTeam = new RepositoryTeam();
                        $repositoryTeam->setRepository($repository);
                        $repositoryTeam->setTeam($teamService->getById($teamData['id']));
                        $repositoryTeam->setPermission($teamData['permission']);

                        $this->getRepositoryTeamService()->persist($repositoryTeam);
                    }
                }

                return $this->redirect()->toRoute('project/view', array(
                    'id' => $project->getId()
                ));
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('project', $project);
        return $viewModel;
    }

    public function deleteAction()
    {
        $repository = $this->getRepositoryService()->findById($this->params('id'));
        if (!$repository) {
            return $this->redirect()->toRoute('project/overview');
        }

        if (!$this->userAccess('repository_delete')) {
            return $this->redirect()->toRoute('project/view', array(
                'id' => $repository->getProject()->getId()
            ));
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $this->getRepositoryService()->remove($repository);
            }
            return $this->redirect()->toRoute('project/view', array(
                'id' => $repository->getProject()->getId()
            ));
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('repository', $repository);
        return $viewModel;
    }

    public function viewTreeAction()
    {
        $repository = $this->getRepositoryService()->findById($this->params('id'));
        if (!$repository) {
            return $this->redirect()->toRoute('project/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('repository', $repository);
        $viewModel->setVariable('repositoryTree', $this->scmRepositoryTree($repository));
        return $viewModel;

    }
}
