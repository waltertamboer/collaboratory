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
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class KeysService implements ServiceManagerAwareInterface
{
    private $mapper;
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
        $this->getMapper()->persist($key);
        return $this;
    }

    public function remove(SshKey $key)
    {
        $this->getMapper()->remove($key);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
