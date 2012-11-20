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

        $this->synchronize();
        return $this;
    }

    public function remove(SshKey $key)
    {
        $eventArgs = array('key' => $key);

        $this->eventManager->trigger('collab.ssh.key.delete.pre', $this, $eventArgs);
        $this->getMapper()->remove($key);
        $this->eventManager->trigger('collab.ssh.key.delete.post', $this, $eventArgs);

        $this->synchronize();
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

    public function synchronize()
    {
        $currDir = \getcwd();
        $path = $currDir . DIRECTORY_SEPARATOR . 'authorized_keys';

        $content = '';
        $content .= '#collaboratory' . PHP_EOL;
        foreach ($this->getMapper()->findAll() as $sshKey) {
            $createdBy = $sshKey->getCreatedBy();
            $username = $createdBy->getId();

            $parameters = array();
            $parameters[] = 'command="' . $currDir . '/data/shell/ssh-shell ' . $username . '"';
            $parameters[] = 'no-port-forwarding';
            $parameters[] = 'no-x11-forwarding';
            $parameters[] = 'no-agent-forwarding';
            $parameters[] = 'no-pty';

            $content .= implode(',', $parameters) . ' ' . $sshKey->getContent() . PHP_EOL;
        }
        $content .= '#collaboratory' . PHP_EOL;

        if (is_file($path)) {
            $original = file_get_contents($path);

            $content = preg_replace('/#collaboratory.*?#collaboratory\s*/sim', $content, $original);
            file_put_contents($path, $content);
        } else {
            $f = fopen($path, 'a');
            fwrite($f, $content);
            fclose($f);
        }
    }
}
