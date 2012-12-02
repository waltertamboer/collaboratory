<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssue\Controller;

use CollabIssue\Form\IssueForm;
use DateTime;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IssueController extends AbstractActionController
{
    private $issueService;

    public function getIssueService()
    {
        if (!$this->issueService) {
            $this->issueService = $this->getServiceLocator()->get('CollabIssue\Service\IssueService');
        }
        return $this->issueService;
    }

    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $issue = new \CollabIssue\Entity\Issue();
        $issue->setTitle(123);
        $issue->setDescription(123123);
        $issue->setCreationDate(new \DateTime());
        $em->persist($issue);
        $em->flush();


$bug = new \CollabIssue\Entity\Bug();
$bug->setTitle('Bug 1');
$bug->setDescription('The example description.');
$bug->setCreationDate(new \DateTime());
$em->persist($bug);
$em->flush();

//        $bugRepo = $em->getRepository('CollabIssue\Entity\Bug');
//
//        foreach ($bugRepo->findAll() as $bug) {
//            echo $bug->getTitle();
//        }

        exit;

        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function createAction()
    {
        $form = new IssueForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $issue = $form->getData();
                $issue->setCreationDate(new DateTime());
                $issue->setCreatedBy($this->userAuthentication()->getIdentity());
                $this->getIssueService()->persist($issue);

                return $this->redirect()->toRoute('issue/overview');
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }

}
