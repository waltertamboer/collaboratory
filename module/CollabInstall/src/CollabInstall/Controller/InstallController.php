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
use CollabInstall\Service\Installer;
use CollabInstall\Service\SystemPathChecker;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InstallController extends AbstractActionController
{
	private $session;

	public function getSession()
	{
		if (!$this->session) {
			$this->session = new \Zend\Session\Container('installer');
		}
		return $this->session;
	}

	public function indexAction()
	{
		$systemPathChecker = new SystemPathChecker();

		$viewModel = new ViewModel();
		$viewModel->setVariable('systemSettings', $systemPathChecker->getSettings());
		$viewModel->setVariable('canContinue', true);
		return $viewModel;
	}

	public function databaseAction()
	{
		$session = $this->getSession();
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
				$session['database'] = new ArrayObject();
				$session['database']->exchangeArray($form->getData());

                return $this->redirect()->toRoute('install/account');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;

	}

	public function accountAction()
	{
		$session = $this->getSession();
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

	public function finishAction()
	{
        $form = new FinishForm();
		$session = $this->getSession();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
				$installer = new Installer($this->getServiceLocator());
				$installer->run($session['database'], $session['account']);

                return $this->redirect()->toRoute('dashboard');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('database', $session['database']);
        $viewModel->setVariable('account', $session['account']);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
	}
}
