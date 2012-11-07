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

use Application\Entity\SshKey;
use Application\Form\AddSshForm;
use DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    private $sshService;

    private function getSshService()
    {
        if ($this->sshService === null) {
            $this->sshService = $this->getServiceLocator()->get('ssh.service');
        }
        return $this->sshService;
    }

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
            $sshKey = new SshKey();

            $form->bind($sshKey);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $sshKey->setCreatedBy(1);
                $sshKey->setCreatedOn(new DateTime());

                $this->getSshService()->persist($sshKey);
                return $this->redirect()->toRoute('account/ssh');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }
}
