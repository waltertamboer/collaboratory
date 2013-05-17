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
use CollabScm\Service\RepositoryTeamService;
use CollabScmGit\Api\Command\GitClone;
use CollabScmGit\Api\Command\Raw;

class Gitolite
{
    private $isValid;
    private $repository;
    private $localPath;
    private $storagePath;
    private $repositoryService;
    private $repositoryTeamService;

    public function __construct($repository, $localPath, $storagePath)
    {
        $this->isValid = strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN';
        $this->repository = $repository;
        $this->localPath = $localPath;
        $this->storagePath = $storagePath;
    }

    public function getRepositoryService()
    {
        return $this->repositoryService;
    }

    public function setRepositoryService(RepositoryService $repositoryService)
    {
        $this->repositoryService = $repositoryService;
    }

    public function setRepositoryTeamService(RepositoryTeamService $repositoryTeamService)
    {
        $this->repositoryTeamService = $repositoryTeamService;
    }

    public function load()
    {
        if (!$this->isValid) {
            return;
        }

        if (!is_dir($this->localPath)) {
            $command = new GitClone();
            $command->setRepository($this->repository);
        } else {
            $command = new Raw('pull');
        }
        $command->setPath($this->localPath);
        $command->execute();
    }

    public function persist()
    {
        if (!$this->isValid) {
            return;
        }

        $configFile = $this->localPath . '/conf/gitolite.conf';

        $repositories = $this->repositoryService->findAll();

        // Sort the repositories access rights:
        $content = 'repo gitolite-admin' . PHP_EOL;
        $content .= "\t" . 'RW+ = www-data' . PHP_EOL . PHP_EOL;
        foreach ($repositories as $repository) {
            // Add the repository, the www-data user always has access to it:
            $name = preg_replace('/[^a-z0-9_-]/i', '', $repository->getName());
            $content .= 'repo ' . $name . PHP_EOL;
            $content .= "\t" . 'RW+ = www-data' . PHP_EOL . PHP_EOL;

            $repositoryTeams = $this->repositoryTeamService->findBy(array(
                'repository' => $repository,
            ));

            foreach ($repositoryTeams as $repositoryTeam) {
                $content .= "\t";
                switch ($repositoryTeam->getPermission()) {
                    case 'pull':
                        $content .= 'R';
                        break;

                    case 'push':
                        $content .= 'RW+';
                        break;
                }
                $content .= ' =';

                $team = $repositoryTeam->getTeam();
                foreach ($team->getMembers() as $member) {
                    $content .= ' ' . $member->getId();
                }
                $content .= PHP_EOL;
            }
        }

        file_put_contents($configFile, $content);

        $addCommand = new Raw('add .');
        $addCommand->setPath($this->localPath);
        $addCommand->execute();

        $commitCommand = new Raw('commit -m "Updated the settings."');
        $commitCommand->setPath($this->localPath);
        $commitCommand->execute();

        $pushCommand = new Raw('push origin');
        $pushCommand->setPath($this->localPath);
        $pushCommand->execute();
    }

    public function removeRepository(Repository $repository)
    {
        if (!$this->isValid) {
            return;
        }
    }

    public function renameRepository(Repository $repository)
    {
        if (!$this->isValid) {
            return;
        }
    }
}
