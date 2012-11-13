<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Controller;

use CollabApplication\Form\DeleteForm;
use CollabUser\Entity\User;
use CollabUser\Form\AccountForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
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
        $accounts = $this->getUserService()->findAll();

        $viewModel = new ViewModel();
        $viewModel->setVariable('accounts', $accounts);
        return $viewModel;
    }

    public function createAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

            // TODO: Create a nicer way to handle this, maybe with the event manager?
            $data = $this->getTeamService()->findAjax($request->getQuery('query'));

            die(json_encode($data));
        }

        $userTeams = array();

        $form = new AccountForm($this->getTeamService());
        $form->setServiceManager($this->getServiceLocator());

        if ($request->isPost()) {
            $user = new User();

            $form->bind($user);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserService()->persist($user);
                return $this->redirect()->toRoute('account/overview');
            }

            // Find the teams:
            // TODO: Create a nicer way to handle this, maybe with the event manager?
            $postData = $request->getPost('teams');
            foreach ($postData as $team) {
                $userTeams[] = $this->getTeamService()->getById($team['id']);
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('userTeams', $userTeams);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function updateAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {

            // TODO: Create a nicer way to handle this, maybe with the event manager?
            $data = $this->getTeamService()->findAjax($request->getQuery('query'));

            die(json_encode($data));
        }

        $userService = $this->getUserService();
        $user = $userService->findById($this->params('id'));
        if (!$user) {
            return $this->redirect()->toRoute('account/overview');
        }

        $userTeams = $user->getTeams();

        $form = new AccountForm($this->getTeamService());
        $form->setServiceManager($this->getServiceLocator());
        $form->bind($user);

        $form->getInputFilter()->getUniqueIdentity()->addException($user->getIdentity());

        if ($request->isPost()) {
            $user->clearTeams();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $credential = $user->getCredential();
                $credential = $userService->encryptCredential($credential);
                $user->setCredential($credential);

                $userService->persist($user);
                return $this->redirect()->toRoute('account/overview');
            }

            $userTeams = array();

            // Find the teams:
            // TODO: Create a nicer way to handle this, maybe with the event manager?
            $postData = $request->getPost('teams');
            foreach ($postData as $team) {
                $userTeams[] = $this->getTeamService()->getById($team['id']);
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('user', $user);
        $viewModel->setVariable('userTeams', $userTeams);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $userService = $this->getUserService();
        $user = $userService->findById($this->params('id'));
        if (!$user || $user->getId() == $this->userAuthentication()->getIdentity()->getId()) {
            return $this->redirect()->toRoute('account/overview');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $userService->remove($user);
            }
            return $this->redirect()->toRoute('account/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('user', $user);
        return $viewModel;
    }
}
