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

use CollabUser\Entity\SshKey;
use CollabUser\Form\AddSshForm;
use CollabUser\Form\LoginForm;
use CollabUser\Form\ProfileForm;
use DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    private $sshService;
    private $userService;

    private function getSshService()
    {
        if ($this->sshService === null) {
            $this->sshService = $this->getServiceLocator()->get('ssh.service');
        }
        return $this->sshService;
    }

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
        if (isset($_GET['debug'])) {
            $username = 'waltertamboer';
            $keyFile = '.ssh/authorized_keys';

            if (isset($_POST['reset'])) {
                unlink($keyFile);
                
                exit;
            }

            if (isset($_POST['submit'])) {
                $options = array(
                    'command="/home/git/data/shell/collaboratory-shell ' . $username . '"',
                    'no-port-forwarding',
                    'no-x11-forwarding',
                    'no-agent-forwarding',
                    'no-pty'
                );

                $content = is_file($keyFile) ? file_get_contents($keyFile) : '';
                if ($options) {
                    $content .= implode(',', $options) . ' ';
                }
                $content .= trim($_POST['key']) . PHP_EOL;

                file_put_contents($keyFile, $content);

                exit;
            }

            echo '<form action="" method="post">
                <p>
                    Name:
                    <input type="text" name="name" value="Test Key" />
                </p>
                <p>
                    Key:
                    <textarea name="key">ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEA3gOe5ymAGvLzMcL5EEWI8l6PfQr2py5CqMP7/CGuipsLE62WP+CxpBPr1WXRejlbl9Ypdurxwg/KKiV0z3JD1PpW9EsfxhgJwTQMAznIQlPJdDL1sUCOJpDXvxyMN+Hmc0S2GmGwfZIkaTvW9Q+4YuyS7HyUb2TJdziIEEWUjSTcmoh5xwUA/CTHDLYDtM+DVNXSDCGrktaNQjSvlcJ0LgSaCi/ppPpmzu9/IB9/6yK6k3yJ2AkJt6VNkVNtAXK5TmVPqFYjOHFknOwl5qrHmkb2Zl/USvsZU2J5wfB2g7b1225rx0xAitwmg4XlLh978y3Wt4mzF7TtqcuZX6GVSw== Walter@WALTER-PC</textarea>
                </p>
                <p>
                    <input type="submit" name="submit" value="Save" />
                    <input type="submit" name="reset" value="Delete All" />
                </p>
            </form>

            <hr />';

            if (is_file($keyFile)) {
                echo '<pre>';
                echo file_get_contents($keyFile);
                echo '</pre>';
            }

            exit;
        }
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

        return $this->redirect()->toRoute('user/login');
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
