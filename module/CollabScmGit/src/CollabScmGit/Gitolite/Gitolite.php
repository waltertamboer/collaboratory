<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmGit\Gitolite;

use CollabScm\Entity\Repository;
use CollabScm\Service\RepositoryService;
use CollabScmGit\Api\Command\GitClone;
use CollabScmGit\Api\Command\Pull;
use CollabScmGit\Api\Command\Push;

class Gitolite
{
    private $repository;
    private $localPath;
    private $storagePath;
    private $repositoryService;

    public function __construct($repository, $localPath, $storagePath)
    {
        $this->repository = $repository;
        $this->localPath = $localPath;
        $this->storagePath = $storagePath;
    }

    public function setRepositoryService(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    public function load()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if (!is_dir($this->localPath)) {
                $cloneCommand = new GitClone();
                $cloneCommand->setRepository($this->repository);
                $cloneCommand->setPath($this->localPath);
                $cloneCommand->execute();
            } else {
                $pullCommand = new Pull();
                $pullCommand->setPath($this->localPath);
                $pullCommand->execute();
            }
        }
    }

    public function persist()
    {
        $configFile = $this->localPath . '/conf/gitolite.conf';

        $repositories = $this->repositoryService->findAll();

        $gitRepos = array();
        foreach ($repositories as $repository) {
            $name = preg_replace('/[^a-z0-9_-]/i', '', $repository->getName());

            $gitRepos[$name] = array();
        }

        // Sort the repositories access rights:
        $content = '';
        foreach ($gitRepos as $name => $users) {
            if (count($users)) {
                $sortedUsers = array();
                foreach ($users as $name => $access) {
                    if (!isset($sortedUsers[$access])) {
                        $sortedUsers[$access][] = $name;
                    }
                }

                $content .= 'repo ' . $name . PHP_EOL;
                foreach ($sortedUsers as $access => $users) {
                    $content .= "\t" . $access . ' = ' . implode(' ', $users) . PHP_EOL;
                }
                $content .= PHP_EOL;
            }
        }

        file_put_contents($configFile, $content);

        $pushCommand = new Push();
        $pushCommand->setPath($this->localPath);
        $pushCommand->execute();
    }

    public function removeRepository(Repository $repository)
    {
    }

    public function renameRepository(Repository $repository)
    {
    }
}
