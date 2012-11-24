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
        $this->getMapper()->persist($project);

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

        $this->getMapper()->remove($project);

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
