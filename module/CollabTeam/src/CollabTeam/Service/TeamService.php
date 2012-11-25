<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\Service;

use CollabTeam\Entity\Team;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class TeamService implements ServiceManagerAwareInterface
{
    private $eventManager;
    private $mapper;
    private $serviceManager;

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabTeam');
        }
        return $this->eventManager;
    }

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('team.mapper');
        }
        return $this->mapper;
    }

    public function findAjax($query)
    {
        return $this->getMapper()->findAjax($query);
    }

    public function getAll()
    {
        return $this->getMapper()->getAll();
    }

    public function getById($id)
    {
        return $this->getMapper()->getById($id);
    }

    public function persist(Team $team)
    {
        $eventArgs = array('team' => $team, 'newTeam' => !$team->getId());

        $this->getEventManager()->trigger('persist.pre', $this, $eventArgs);
        $this->getMapper()->persist($team);
        $this->getEventManager()->trigger('persist.post', $this, $eventArgs);

        return $this;
    }

    public function remove(Team $team)
    {
        $eventArgs = array('team' => $team);

        $this->getEventManager()->trigger('remove.pre', $this, $eventArgs);
        $this->getMapper()->remove($team);
        $this->getEventManager()->trigger('remove.post', $this, $eventArgs);

        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
