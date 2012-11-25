<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Service;

use CollabApplication\Entity\ApplicationEvent;
use CollabApplication\Mapper\ApplicationEventsMapperInterface;

class ApplicationEvents
{
    private $mapper;

    public function __construct(ApplicationEventsMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getMapper()
    {
        return $this->mapper;
    }

    public function create()
    {
        return new ApplicationEvent();
    }

    public function findAll($criteria = array())
    {
        return $this->getMapper()->findBy($criteria, array(
            'creationDate' => 'desc'
        ));
    }

    public function findDashboard($limit, $offset = 0)
    {
        return $this->getMapper()->findBy(array(), array(
            'creationDate' => 'desc'
        ), $limit, $offset);
    }

    public function persist(ApplicationEvent $event)
    {
        $this->getMapper()->persist($event);
        return $this;
    }

    public function remove(ApplicationEvent $event)
    {
        $this->getMapper()->remove($event);
        return $this;
    }
}
