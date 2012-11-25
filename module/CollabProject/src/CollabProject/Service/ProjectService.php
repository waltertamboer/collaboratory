<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Service;

use CollabProject\Entity\Project;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class ProjectService implements ServiceManagerAwareInterface
{
    private $eventManager;
    private $mapper;
    private $serviceManager;

    private function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabProject');
        }
        return $this->eventManager;
    }

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('project.mapper');
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

    public function persist(Project $project)
    {
        $eventArg = array('project' => $project, 'isNew' => !$project->getId());

        $this->getEventManager()->trigger('persist.pre', $this, $eventArg);
        $this->getMapper()->persist($project);
        $this->getEventManager()->trigger('persist.post', $this, $eventArg);

        $oldProjectName = $project->getPreviousName();
        $projectPath = $this->getProjectPath($project->getName());

        if ($oldProjectName && $oldProjectName != $project->getName()) {
            $oldProjectPath = $this->getProjectPath($oldProjectName);
            if (is_dir($oldProjectPath)) {
                rename($oldProjectPath, $projectPath);
            } else {
                mkdir($projectPath, 0777);
                chmod($projectPath, 0777);
            }
        } else if (!is_dir($projectPath)) {
            mkdir($projectPath, 0777);
            chmod($projectPath, 0777);
        }

        return $this;
    }

    public function remove(Project $project)
    {
        // Delete the project on the file system:
        $path = realpath($this->getProjectPath($project->getName()));
        if (is_dir($path)) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $command = 'rmdir /Q /S ' . $path;
            } else {
                $command = 'rm -rf ' . $path;
            }
            exec($command);
        }

        $eventArg = array('project' => $project);

        $this->getEventManager()->trigger('remove.pre', $this, $eventArg);
        $this->getMapper()->remove($project);
        $this->getEventManager()->trigger('remove.post', $this, $eventArg);

        return $this;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getProjectPath($name)
    {
        $projectName = preg_replace('/[^a-z0-9-]+/i', '', $name);

        return getcwd() . '/data/projects/' . strtolower($projectName);
    }
}
