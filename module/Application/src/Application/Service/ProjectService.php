<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Service;

use Application\Entity\Project;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class ProjectService implements ServiceManagerAwareInterface
{
    private $mapper;
    private $serviceManager;

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('project.mapper');
        }
        return $this->mapper;
    }

    public function getAll()
    {
        return $this->getMapper()->getAll();
    }

    public function getById($id)
    {
        return $this->getMapper()->getById($id);
    }

    public function persist(Project $project)
    {
        $this->getMapper()->persist($project);
        return $this;
    }

    public function remove(Project $project)
    {
        $this->getMapper()->remove($project);
        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
