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
    const AUTH_ADAPTER_NAME = 'collabuser.adapter';
    const AUTH_SERVICE_NAME = 'collabuser.service';
    const AUTH_STORAGE_NAME = 'collabuser.storage';

    protected $authAdapter;
    protected $authService;
    protected $serviceManager;
    protected $storage;
    protected $resolvedIdentity;

    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    public function getIdentity()
    {
        if (!$this->resolvedIdentity) {
            $id = $this->getAuthService()->getIdentity();

            $mapper = $this->getAuthAdapter()->getMapper();
            $this->resolvedIdentity = $mapper->findById($id);
        }
        return $this->resolvedIdentity;
    }

    public function getAuthAdapter()
    {
        if (null === $this->authAdapter) {
            $adapter = $this->getServiceManager()->get(self::AUTH_ADAPTER_NAME);
            $this->setAuthAdapter($adapter);
        }
        return $this->authAdapter;
    }

    public function setAuthAdapter(AdapterInterface $authAdapter)
    {
        $this->authAdapter = $authAdapter;
        return $this;
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

    public function getStorage()
    {
        if ($this->storage === null) {
            $this->storage = $this->getServiceManager()->get(self::AUTH_STORAGE_NAME);
        }
        return $this->storage;
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
        $adapter = $this->getAuthAdapter();
        $adapter->setIdentity($identity);
        $adapter->setCredential($credential);

        $authResult = $this->getAuthService()->authenticate($adapter);

        $result = false;
        if ($authResult->isValid()) {
            $result = true;

            // Write the identity to the storage device:
            $this->getStorage()->write($authResult->getIdentity());
        }

        return $result;
    }
}
