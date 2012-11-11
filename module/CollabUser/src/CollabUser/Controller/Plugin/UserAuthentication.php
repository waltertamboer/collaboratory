<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Controller\Plugin;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserAuthentication extends AbstractPlugin implements ServiceManagerAwareInterface
{
    const AUTH_SERVICE_NAME = 'collabuser.authservice';

    protected $authAdapter;
    protected $authService;
    protected $serviceManager;
    protected $storage;

    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    public function getAuthService()
    {
        if (null === $this->authService) {
            $authService = $this->getServiceManager()->get(self::AUTH_SERVICE_NAME);
            $this->setAuthService($authService);
        }
        return $this->authService;
    }

    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager->getServiceLocator();
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function logout()
    {
        $this->getAuthService()->clearIdentity();
    }

    public function login($identity, $credential)
    {
        $result = false;
        $authService = $this->getAuthService();

        $adapter = $authService->getAdapter();
        $adapter->setIdentity($identity);
        $adapter->setCredential($credential);

        $authResult = $authService->authenticate($adapter);
        if ($authResult->isValid()) {
            $result = true;

            // Write the identity to the storage device:
            $authService->getStorage()->write($authResult->getIdentity());
        }

        return $result;
    }
}
