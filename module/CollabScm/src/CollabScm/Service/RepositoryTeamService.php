<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Service;

use CollabScm\Entity\Repository;
use CollabScm\Entity\RepositoryTeam;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class RepositoryTeamService implements ServiceManagerAwareInterface
{
    private $mapper;
    private $serviceManager;

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('CollabScm\Mapper\RepositoryTeam');
        }
        return $this->mapper;
    }

    public function clearForRepository(Repository $repository)
    {
        $this->getMapper()->clearForRepository($repository);
        return $this;
    }

    public function findBy(array $criteria)
    {
        return $this->getMapper()->findBy($criteria);
    }

    public function findById($id)
    {
        return $this->getMapper()->findById($id);
    }

    public function persist(RepositoryTeam $repositoryTeam)
    {
        $this->getMapper()->persist($repositoryTeam);
        return $this;
    }

    public function remove(RepositoryTeam $repositoryTeam)
    {
        $this->getMapper()->remove($repositoryTeam);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
