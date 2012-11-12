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
    private $userService;

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
        $form = new AccountForm();
        $form->setServiceManager($this->getServiceLocator());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();

            $form->bind($user);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserService()->persist($user);
                return $this->redirect()->toRoute('account/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function updateAction()
    {
        $userService = $this->getUserService();
        $user = $userService->findById($this->params('id'));
        if (!$user) {
            return $this->redirect()->toRoute('account/overview');
        }

        $form = new AccountForm();
        $form->setServiceManager($this->getServiceLocator());
        $form->bind($user);

        $form->getInputFilter()->getUniqueIdentity()->addException($user->getIdentity());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $userService->persist($user);
                return $this->redirect()->toRoute('account/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('user', $user);
        $viewModel->setVariable('teamMembers', array());
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
