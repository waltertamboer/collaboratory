<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
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
    private $userService;

    private function getTeamService()
    {
        if ($this->teamService === null) {
            $this->teamService = $this->getServiceLocator()->get('team.service');
        }
        return $this->teamService;
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
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $data = $this->getUserService()->findAjax($request->getQuery('query'));

            die(json_encode($data));
        }

        $form = new TeamForm($this->getUserService());

        $teamMembers = array();
        if ($request->isPost()) {
            $team = new Team();

            $form->bind($team);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $team->setCreatedBy($this->userAuthentication()->getIdentity());
                $this->getTeamService()->persist($team);
                return $this->redirect()->toRoute('team/overview');
            }

            // Find the teams:
            $postData = $request->getPost('team');
            foreach ($postData['members'] as $member) {
                $teamMembers[] = $this->getUserService()->findById($member['id']);
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('teamMembers', $teamMembers);
        $viewModel->setVariable('teamProjects', array());
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function updateAction()
    {
        $team = $this->getTeamService()->getById($this->params('id'));
        if (!$team) {
            return $this->redirect()->toRoute('team/overview');
        }

        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $data = $this->getUserService()->findAjax($request->getQuery('query'));

            die(json_encode($data));
        }

        $form = new TeamForm($this->getUserService());
        $form->bind($team);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTeamService()->persist($team);
                return $this->redirect()->toRoute('team/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('team', $team);
        $viewModel->setVariable('teamMembers', $team->getMembers());
        $viewModel->setVariable('teamProjects', $team->getProjects());
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $team = $this->getTeamService()->getById($this->params('id'));
        if (!$team) {
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
