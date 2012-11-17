<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSnippet\Controller;

use CollabApplication\Form\DeleteForm;
use CollabSnippet\Entity\Snippet;
use CollabSnippet\Form\SnippetForm;
use DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SnippetController extends AbstractActionController
{
    private $snippetService;

    private function getSnippetService()
    {
        if ($this->snippetService === null) {
            $this->snippetService = $this->getServiceLocator()->get('snippet.service');
        }
        return $this->snippetService;
    }

    public function indexAction()
    {
        $snippetService = $this->getSnippetService();

        $viewModel = new ViewModel();
        $viewModel->setVariable('snippets', $snippetService->getAll());
        return $viewModel;
    }

    public function createAction()
    {
        $form = new SnippetForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $snippet = new Snippet();

            $form->bind($snippet);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $snippet->setCreatedBy($this->userAuthentication()->getIdentity());
                $snippet->setCreatedOn(new DateTime());

                $this->getSnippetService()->persist($snippet);
                return $this->redirect()->toRoute('snippet/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function updateAction()
    {
        $snippet = $this->getSnippetService()->getById($this->params('id'));
        if (!$snippet) {
            return $this->redirect()->toRoute('snippet/overview');
        }

        $form = new SnippetForm();
        $form->bind($snippet);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getSnippetService()->persist($snippet);
                return $this->redirect()->toRoute('snippet/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('snippet', $snippet);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $snippet = $this->getSnippetService()->getById($this->params('id'));
        if (!$snippet) {
            return $this->redirect()->toRoute('snippet/overview');
        }

        $form = new DeleteForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $this->getSnippetService()->remove($snippet);
            }
            return $this->redirect()->toRoute('snippet/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('snippet', $snippet);
        return $viewModel;
    }
}
