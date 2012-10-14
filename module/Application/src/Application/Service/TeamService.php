<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class TeamService implements ServiceManagerAwareInterface
{
    private $mapper;
    private $serviceManager;

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('team.mapper');
        }
        return $this->mapper;
    }

    public function getAll()
    {
        return $this->getMapper()->getAll();
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
