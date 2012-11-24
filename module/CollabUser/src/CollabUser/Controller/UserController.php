<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Controller;

use CollabUser\Form\LoginForm;
use CollabUser\Form\ProfileForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    private $userService;

    private function getUserService()
    {
        if ($this->userService === null) {
            $this->userService = $this->getServiceLocator()->get('collabuser.userservice');
        }
        return $this->userService;
    }

    public function profileAction()
    {
        $user = $this->userAuthentication()->getIdentity();

        $form = new ProfileForm();
        $form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserService()->persist($user);
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

    public function loginAction()
    {
        $form = new LoginForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $identity = $form->get('identity')->getValue();
                $credential = $form->get('credential')->getValue();

                if ($this->userAuthentication()->login($identity, $credential)) {
                    return $this->redirect()->toRoute('dashboard');
                }
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

    public function logoutAction()
    {
        $this->userAuthentication()->logout();

        return array();
    }
}
