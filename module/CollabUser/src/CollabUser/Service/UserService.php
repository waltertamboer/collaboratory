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
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserService implements ServiceManagerAwareInterface, EventManagerAwareInterface
{
    private $mapper;
    private $eventManager;
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
        $oldKey = $user->getId() ? $this->findById($user->getId()) : null;

        $eventArgsCreate = array('user' => $user);
        $eventArgsUpdate = array('old' => $oldKey, 'new' => $user);

        if ($oldKey) {
            $this->eventManager->trigger('collab.user.key.update.pre', $this, $eventArgsUpdate);
        } else {
            $this->eventManager->trigger('collab.user.key.create.pre', $this, $eventArgsCreate);
        }

        $this->eventManager->trigger('collab.user.key.persist.pre', $this, $eventArgsCreate);
        $this->getMapper()->persist($user);
        $this->eventManager->trigger('collab.user.key.persist.post', $this, $eventArgsCreate);

        if ($oldKey) {
            $this->eventManager->trigger('collab.user.key.update.post', $this, $eventArgsUpdate);
        } else {
            $this->eventManager->trigger('collab.user.key.create.post', $this, $eventArgsCreate);
        }
        return $this;
    }

    public function remove(User $user)
    {
        $eventArgs = array('user' => $user);

        $this->eventManager->trigger('collab.user.key.delete.pre', $this, $eventArgs);
        $this->getMapper()->remove($user);
        $this->eventManager->trigger('collab.user.key.delete.post', $this, $eventArgs);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }
}
