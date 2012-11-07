<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Controller;

use Application\Form\AddSshForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    public function profileAction()
    {
        $form = new \Application\Form\ProfileForm();

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

    public function loginAction()
    {
        $form = new \Application\Form\ProfileLoginForm();

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

    public function sshAction()
    {
    }

    public function sshAddAction()
    {
        $form = new AddSshForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $project = new Project();
            $form->bind($project);

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProjectService()->persist($project);
                return $this->redirect()->toRoute('project/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }
}
