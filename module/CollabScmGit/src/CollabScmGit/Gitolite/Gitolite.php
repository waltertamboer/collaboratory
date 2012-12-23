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
use CollabScmGit\Api\Command\GitClone;
use CollabScmGit\Api\Command\Pull;

class Gitolite
{
    private $repository;
    private $localPath;
    private $storagePath;

    public function __construct($repository, $localPath, $storagePath)
    {
        $this->repository = $repository;
        $this->localPath = $localPath;
        $this->storagePath = $storagePath;
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

        var_dump($configFile);
        exit;
    }

    public function removeRepository(Repository $repository)
    {
    }

    public function renameRepository(Repository $repository)
    {
    }
}
