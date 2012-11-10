<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class DbAdapter implements AdapterInterface, ServiceManagerAwareInterface
{
    const USER_MAPPER = 'collabuser.mapper';

    private $mapper;
    private $serviceManager;
    private $identity;
    private $credential;

    public function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get(self::USER_MAPPER);
        }
        return $this->mapper;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * Performs an authentication attempt
     *
     * @return Result
     */
    public function authenticate()
    {
        $mapper = $this->getMapper();

        $user = $mapper->findByEmail($this->identity);
        if (!$user) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->identity, array(
                'A record with the supplied identity could not be found.'
            ));
        }

        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);

        if (!$bcrypt->verify($this->credential, $user->getCredential())) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->identity, array(
                'Supplied credential is invalid.'
            ));
        }

        return new Result(Result::SUCCESS, $user->getId(), array());
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
