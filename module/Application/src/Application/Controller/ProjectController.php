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

use Application\Entity\Project;
use Application\Form\Delete;
use Application\Form\ProjectForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    private $projectService;

    private function getProjectService()
    {
        if ($this->projectService === null) {
            $this->projectService = $this->getServiceLocator()->get('project.service');
        }
        return $this->projectService;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariable('projects', $this->getProjectService()->getAll());
        return $viewModel;
    }

    public function createAction()
    {
        $form = new ProjectForm();

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

    public function updateAction()
    {
        $project = $this->getProjectService()->getById($this->params('id'));
        if (!$project) {
            return $this->redirect()->toRoute('project/overview');
        }

        $form = new ProjectForm();
        $form->bind($project);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProjectService()->persist($project);
                return $this->redirect()->toRoute('project/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('project', $project);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function deleteAction()
    {
        $project = $this->getProjectService()->getById($this->params('id'));
        if (!$project) {
            return $this->redirect()->toRoute('project/overview');
        }

        $form = new Delete();

        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('yes') != null) {
                $this->getProjectService()->remove($project);
            }
            return $this->redirect()->toRoute('project/overview');
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setVariable('project', $project);
        return $viewModel;
    }

}