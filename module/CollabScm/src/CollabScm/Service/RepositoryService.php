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
use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class RepositoryService implements ServiceManagerAwareInterface
{
    private $eventManager;
    private $mapper;
    private $serviceManager;

    private function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabScm');
        }
        return $this->eventManager;
    }

    private function getMapper()
    {
        if ($this->mapper === null) {
            $this->mapper = $this->serviceManager->get('CollabScm\Mapper\Repository');
        }
        return $this->mapper;
    }

    public function getLatestCommit(Repository $repository)
    {
        $repositoryPath = $this->getRepositoryPath($repository);

        $result = array();
        if ($repository->getType() == 'git') {
            $command = new \CollabScmGit\Api\Command\RevParse();
            $command->setRepository($repositoryPath);

            $result = $command->execute();
        }
        return $result;
    }

    private function getRepositoryPath(Repository $repository)
    {
        $project = $repository->getProject();

        $projectName = preg_replace('/[^a-z0-9-]+/i', '', $project->getName());
        $projectPath = getcwd() . '/data/projects/' . strtolower($projectName) . '/repositories/';

        $repoName = preg_replace('/[^a-z0-9-]+/i', '', $repository->getName());

        return realpath($projectPath . '/' . strtolower($repoName));
    }

    public function getTree(Repository $repository, $path)
    {
        $repositoryPath = $this->getRepositoryPath($repository);

        $result = array();
        if ($repository->getType() == 'git') {
            $command = new \CollabScmGit\Api\Command\ListTree();
            $command->setPath('.' . rtrim($path, '/') . '/');
            $command->setRepository($repositoryPath);

            $result = $command->execute();
        }
        return $result;
    }

    public function findBy(array $criteria)
    {
        return $this->getMapper()->findBy($criteria);
    }

    public function findById($id)
    {
        return $this->getMapper()->findById($id);
    }

    public function persist(Repository $repository)
    {
        $projectName = $repository->getProject()->getName();
        $projectPath = $this->getProjectPath($projectName);

        if (!is_dir($projectPath)) {
            mkdir($projectPath, 0777);
            chmod($projectPath, 0777);
        }

        $projectPath = realpath($projectPath);

        $oldRepositoryName = $repository->getPreviousName();
        $repositoryPath = $this->buildRepositoryPath($projectPath, $repository->getName());

        $shouldInitialize = false;
        if ($oldRepositoryName && $oldRepositoryName != $repository->getName()) {
            $oldRepositoryPath = $this->buildRepositoryPath($projectPath, $oldRepositoryName);
            if (is_dir($oldRepositoryPath)) {
                rename($oldRepositoryPath, $repositoryPath);
                $this->deleteDirectory($oldRepositoryPath);
            } else if (!is_dir($repositoryPath)) {
                mkdir($repositoryPath, 0777);
                chmod($repositoryPath, 0777);
                $shouldInitialize = true;
            }
        } else if (!is_dir($repositoryPath)) {
            mkdir($repositoryPath, 0777);
            chmod($repositoryPath, 0777);
            $shouldInitialize = true;
        }

        $eventArgs = array(
            'repository' => $repository,
            'isNew' => !$repository->getId(),
            'shouldInitialize' => $shouldInitialize,
            'repositoryPath' => realpath($repositoryPath),
        );

        $this->getEventManager()->trigger('persist.pre', $this, $eventArgs);
        $this->getMapper()->persist($repository);
        $this->getEventManager()->trigger('persist.post', $this, $eventArgs);

        return $this;
    }

    public function remove(Repository $repository)
    {
        // Delete the repository on the file system:
        $projectName = $repository->getProject()->getName();
        $projectPath = $this->getProjectPath($projectName);

        $path = realpath($this->buildRepositoryPath($projectPath, $repository->getName()));
        $this->deleteDirectory($path);

        $eventArg = array('repository' => $repository);

        $this->getEventManager()->trigger('remove.pre', $this, $eventArg);
        $this->getMapper()->remove($repository);
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

        return getcwd() . '/data/projects/' . strtolower($projectName) . '/repositories/';
    }

    private function buildRepositoryPath($projectPath, $name)
    {
        $repoName = preg_replace('/[^a-z0-9-]+/i', '', $name);

        return $projectPath . DIRECTORY_SEPARATOR . strtolower($repoName);
    }

    private function deleteDirectory($path)
    {
        if (is_dir($path)) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $command = 'rmdir /Q /S ' . $path;
            } else {
                $command = 'rm -rf ' . $path;
            }
            exec($command);
        }
    }
}
