<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserAccess extends AbstractPlugin implements ServiceManagerAwareInterface
{
    const ACCESS_SERVICE_NAME = 'CollabUser\Access';

    protected $access;
    protected $serviceManager;

    public function __invoke($permission, $assert = null)
    {
        return $this->isGranted($permission, $assert);
    }

    public function getAccess()
    {
        if (!$this->access) {
            $this->access = $this->getServiceManager()->get(self::ACCESS_SERVICE_NAME);
        }
        return $this->access;
    }

    public function isGranted($permission, $assert = null)
    {
        $access = $this->getAccess();

        return $access->isGranted($permission, $assert);
    }

    public function getServiceManager()
    {
        return $this->serviceManager->getServiceLocator();
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
