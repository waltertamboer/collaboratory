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

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TeamController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
        $form = new \Application\Form\Team();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($request->getPost('save')) {
                $exam = new Exam();
                $form->bind($exam);

                if ($form->isValid()) {
                    $this->getExamService()->persist($exam);
                    return $this->redirect()->toRoute('elearning/wildcard');
                }
            } else {
                return $this->redirect()->toRoute('elearning/wildcard');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        $viewModel->setTerminal($request->isXmlHttpRequest());
        return $viewModel;
    }

    public function updateAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

}
