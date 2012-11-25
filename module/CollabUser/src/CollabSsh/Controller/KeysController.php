<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSsh\Controller;

use CollabApplication\Form\DeleteForm;
use CollabSsh\Entity\SshKey;
use CollabSsh\Form\SshForm;
use DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class KeysController extends AbstractActionController
{

    private $sshService;

    private function getSshService()
    {
        if ($this->sshService === null) {
            $this->sshService = $this->getServiceLocator()->get('CollabSsh\Service\KeysService');
        }
        return $this->sshService;
    }

    public function indexAction()
    {
        $identity = $this->userAuthentication()->getIdentity();
        $sshService = $this->getSshService();

        $viewModel = new ViewModel();
        $viewModel->setVariable('keys', $sshService->findForUser($identity));
        return $viewModel;
    }

    public function createAction()
    {
        $access = $this->getServiceLocator()->get('CollabUser\Access');
        if (!$access->isGranted('ssh_create')) {
            return $this->redirect()->toRoute('ssh/overview');
        }

        $form = new SshForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $sshKey = new SshKey();

            $form->bind($sshKey);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $sshKey->setCreatedBy($this->userAuthentication()->getIdentity());
                $sshKey->setCreatedOn(new DateTime());

                $this->getSshService()->persist($sshKey);
                return $this->redirect()->toRoute('ssh/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $sshKey = $this->getSshService()->findById($this->params('id'));
        if (!$sshKey) {
            return $this->redirect()->toRoute('ssh/overview');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $this->getSshService()->remove($sshKey);
            }
            return $this->redirect()->toRoute('ssh/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('sshKey', $sshKey);
        return $viewModel;
    }

}
