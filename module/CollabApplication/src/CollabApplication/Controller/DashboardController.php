<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DashboardController extends AbstractActionController
{
    private $applicationEvents;

    public function getApplicationEvents()
    {
        if (!$this->applicationEvents) {
            $name = 'CollabApplication\Service\ApplicationEvents';
            $this->applicationEvents = $this->getServiceLocator()->get($name);
        }
        return $this->applicationEvents;
    }

    public function indexAction()
    {
//        $command = new \CollabScmGit\Command\LsTree();
//        $command->setPath('.');
//        $result = $command->execute();
//
//        var_dump($result);
//        exit;

        $viewModel = new ViewModel();
        $viewModel->setVariable('applicationEvents', $this->getApplicationEvents()->findDashboard(25));
        return $viewModel;
    }
}
