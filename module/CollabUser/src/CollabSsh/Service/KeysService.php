<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSsh\Service;

use CollabSsh\Entity\SshKey;
use CollabUser\Entity\User;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class KeysService implements ServiceManagerAwareInterface, EventManagerAwareInterface
{
    private $mapper;
    private $eventManager;
    private $serviceManager;

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('CollabSsh\Mapper\KeysMapper');
        }
        return $this->mapper;
    }

    public function findAll()
    {
        return $this->getMapper()->findAll();
    }

    public function findById($id)
    {
        return $this->getMapper()->findById($id);
    }

    public function findForUser(User $user)
    {
        return $this->getMapper()->findForUser($user);
    }

    public function persist(SshKey $key)
    {
        $oldKey = $key->getId() ? $this->findById($key->getId()) : null;

        $eventArgsCreate = array('key' => $key);
        $eventArgsUpdate = array('old' => $oldKey, 'new' => $key);

        if ($oldKey) {
            $this->eventManager->trigger('collab.ssh.key.update.pre', $this, $eventArgsUpdate);
        } else {
            $this->eventManager->trigger('collab.ssh.key.create.pre', $this, $eventArgsCreate);
        }

        $this->eventManager->trigger('collab.ssh.key.persist.pre', $this, $eventArgsCreate);
        $this->getMapper()->persist($key);
        $this->eventManager->trigger('collab.ssh.key.persist.post', $this, $eventArgsCreate);

        if ($oldKey) {
            $this->eventManager->trigger('collab.ssh.key.update.post', $this, $eventArgsUpdate);
        } else {
            $this->eventManager->trigger('collab.ssh.key.create.post', $this, $eventArgsCreate);
        }
        return $this;
    }

    public function remove(SshKey $key)
    {
        $eventArgs = array('key' => $key);

        $this->eventManager->trigger('collab.ssh.key.delete.pre', $this, $eventArgs);
        $this->getMapper()->remove($key);
        $this->eventManager->trigger('collab.ssh.key.delete.post', $this, $eventArgs);

        return $this;
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

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
