<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall\Controller;

use ArrayObject;
use CollabInstall\Form\AccountForm;
use CollabInstall\Form\DatabaseForm;
use CollabInstall\Form\FinishForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InstallController extends AbstractActionController
{
    private $session;
    private $installer;
    private $settingsChecker;

    private function getSession()
    {
        if (!$this->session) {
            $this->session = new \Zend\Session\Container('installer');
        }
        return $this->session;
    }

    private function getInstaller()
    {
        if (!$this->installer) {
            $this->installer = $this->getServiceLocator()->get('CollabInstall\Installer');
        }
        return $this->installer;
    }

    private function getSettingsChecker()
    {
        if (!$this->settingsChecker) {
            $this->settingsChecker = $this->getServiceLocator()->get('CollabInstall\SettingsChecker');
        }
        return $this->settingsChecker;
    }

    public function indexAction()
    {
        $session = $this->getSession();
        $session['step'] = 0;

        $viewModel = new ViewModel();
        $viewModel->setVariable('systemSettings', $this->getSettingsChecker()->getSettings());
        $viewModel->setVariable('canContinue', true);

        return $viewModel;
    }

    public function databaseAction()
    {
        $session = $this->getSession();
        $session['step'] = 0;

        $viewModel = new ViewModel();
        $form = new DatabaseForm();

        $sessionData = $session['database'];
        if (!$sessionData instanceof ArrayObject) {
            $sessionData = new ArrayObject();
            $sessionData['host'] = 'localhost';
            $sessionData['port'] = '3306';
            $sessionData['username'] = 'root';
            $sessionData['password'] = 'root';
            $sessionData['dbname'] = 'collaboratory';
        }

        $form->bind($sessionData);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                try {
                    $installer = $this->getInstaller();
                    $installer->createConnection($data);

                    $session['database'] = new ArrayObject();
                    $session['database']->exchangeArray($data);

                    return $this->redirect()->toRoute('install/account');
                } catch (\Exception $e) {
                    $viewModel->setVariable('error', $e->getMessage());
                }
            }
        }

        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function accountAction()
    {
        $session = $this->getSession();
        $session['step'] = 0;

        $form = new AccountForm();

        $sessionData = $session['account'] instanceof ArrayObject ? $session['account'] : new ArrayObject();
        $form->bind($sessionData);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $session['account'] = new ArrayObject();
                $session['account']->exchangeArray($form->getData());

                return $this->redirect()->toRoute('install/finish');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function finishConfigAction()
    {
        $session = $this->getSession();

        $installer = $this->getInstaller();
        $installer->createConfigFile($session['database']);
    }

    public function finishAction()
    {
        $form = new FinishForm();
        $session = $this->getSession();

        switch ($session['step']) {
            case 1: {
                    $session['step'] = 2;

                    $installer = $this->getInstaller();
                    $installer->createConfigFile($session['database']);

                    return $this->redirect()->toRoute('install/finish');
                }
            case 2: {
                    $installer = $this->getInstaller();
                    $installer->createDatabase();
                    $installer->createEntities($session['account']);

                    return $this->redirect()->toRoute('dashboard');
                }
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $session['step'] = 1;
                return $this->redirect()->toRoute('install/finish');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('database', $session['database']);
        $viewModel->setVariable('account', $session['account']);
        return $viewModel;
    }

}
