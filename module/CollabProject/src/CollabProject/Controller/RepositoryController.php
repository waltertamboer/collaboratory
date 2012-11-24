<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Controller;

use CollabApplication\Form\DeleteForm;
use CollabProject\Entity\Project;
use CollabProject\Entity\Repository;
use CollabProject\Form\RepositoryForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RepositoryController extends AbstractActionController
{
    private $projectService;
    private $repositoryService;

    private function getProjectService()
    {
        if ($this->projectService === null) {
            $this->projectService = $this->getServiceLocator()->get('project.service');
        }
        return $this->projectService;
    }

    private function getRepositoryService()
    {
        if ($this->repositoryService === null) {
            $this->repositoryService = $this->getServiceLocator()->get('CollabProject\Service\Repository');
        }
        return $this->repositoryService;
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

        $form = new RepositoryForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $repository = new Repository();

            $form->bind($repository);
            $form->setData($request->getPost());

            if ($form->isValid()) {
				$repository->setProject($project);
                $this->getRepositoryService()->persist($repository);
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
}
