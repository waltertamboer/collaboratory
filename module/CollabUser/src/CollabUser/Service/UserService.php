<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Service;

use CollabUser\Entity\User;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserService implements ServiceManagerAwareInterface
{
    private $mapper;
    private $serviceManager;

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('collabuser.usermapper');
        }
        return $this->mapper;
    }

    public function encryptCredential($credential)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);

        return $bcrypt->create($credential);
    }

    public function findAjax($query)
    {
        return $this->getMapper()->findAjax($query);
    }

    public function findAll()
    {
        return $this->getMapper()->findAll();
    }

    public function findByEmail($email)
    {
        return $this->getMapper()->findByEmail($email);
    }

    public function findById($id)
    {
        return $this->getMapper()->findById($id);
    }

    public function persist(User $user)
    {
        $this->getMapper()->persist($user);
        return $this;
    }

    public function remove(User $user)
    {
        $this->getMapper()->remove($user);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
