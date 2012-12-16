<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\Controller;

use CollabApplication\Form\DeleteForm;
use CollabTeam\Entity\Team;
use CollabTeam\Form\TeamForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TeamController extends AbstractActionController
{
    private $teamService;
    private $permissionsService;
    private $projectService;
    private $userService;

    private function getTeamService()
    {
        if ($this->teamService === null) {
            $this->teamService = $this->getServiceLocator()->get('team.service');
        }
        return $this->teamService;
    }

    private function getPermissionsService()
    {
        if ($this->permissionsService === null) {
            $this->permissionsService = $this->getServiceLocator()->get('CollabUser\Service\Permission');
        }
        return $this->permissionsService;
    }

    private function getProjectService()
    {
        if ($this->projectService === null) {
            $this->projectService = $this->getServiceLocator()->get('project.service');
        }
        return $this->projectService;
    }

    private function getUserService()
    {
        if ($this->userService === null) {
            $this->userService = $this->getServiceLocator()->get('collabuser.userservice');
        }
        return $this->userService;
    }

    public function indexAction()
    {
        $teamService = $this->getTeamService();

        $viewModel = new ViewModel();
        $viewModel->setVariable('teams', $teamService->getAll());
        return $viewModel;
    }

    public function createAction()
    {
        if (!$this->userAccess('team_create')) {
            return $this->redirect()->toRoute('team/overview');
        }

        $form = new TeamForm($this->getUserService(),
                $this->getPermissionsService(), $this->getProjectService());

        $permissions = $form->get('permissions')->getProxy();
        $permissions->setObjectManager($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $permissions->setTargetClass('CollabUser\Entity\Permission');
        $permissions->setProperty('name');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $team = $form->getData();
                $team->setCreatedBy($this->userAuthentication()->getIdentity());
                $this->getTeamService()->persist($team);
                return $this->redirect()->toRoute('team/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

    public function updateAction()
    {
        $team = $this->getTeamService()->getById($this->params('id'));
        if (!$team) {
            return $this->redirect()->toRoute('team/overview');
        }

        if (!$this->userAccess('team_update')) {
            return $this->redirect()->toRoute('team/overview');
        }

        $form = new TeamForm($this->getUserService(),
                $this->getPermissionsService(), $this->getProjectService());

        $permissions = $form->get('permissions')->getProxy();
        $permissions->setObjectManager($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
        $permissions->setTargetClass('CollabUser\Entity\Permission');
        $permissions->setProperty('name');

        $form->bind($team);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $team->clearMembers();
            $team->clearProjects();

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTeamService()->persist($team);
                return $this->redirect()->toRoute('team/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('team', $team);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $team = $this->getTeamService()->getById($this->params('id'));
        if (!$team || $team->isRoot()) {
            return $this->redirect()->toRoute('team/overview');
        }

        if (!$this->userAccess('team_delete')) {
            return $this->redirect()->toRoute('team/overview');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $this->getTeamService()->remove($team);
            }
            return $this->redirect()->toRoute('team/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('team', $team);
        return $viewModel;
    }

}
