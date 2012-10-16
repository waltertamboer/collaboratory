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
    }

    public function sshAction()
    {
    }
}
