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
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UserService implements ServiceManagerAwareInterface
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
        $isNew = !$user->getId();
        $eventArgs = array('user' => $user, 'isNew' => $isNew);

        $this->getEventManager()->trigger('persist.pre', $this, $eventArgs);
        $this->getMapper()->persist($user);
        $this->getEventManager()->trigger('persist.post', $this, $eventArgs);

        return $this;
    }

    public function remove(User $user)
    {
        $eventArgs = array('user' => $user);

        $this->getEventManager()->trigger('remove.pre', $this, $eventArgs);
        $this->getMapper()->remove($user);
        $this->getEventManager()->trigger('remove.post', $this, $eventArgs);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabUser');
        }
        return $this->eventManager;
    }
}
