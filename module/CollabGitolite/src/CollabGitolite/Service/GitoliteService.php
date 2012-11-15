<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Service;

use CollabGitolite\Config\Config;
use CollabGitolite\Entity\User;
use CollabGitolite\Entity\Group;
use CollabGitolite\Entity\Repository;

class GitoliteService
{
    private $config;

    public function getConfig()
    {
        if ($this->config === null) {
            // @todo get it from the service manager?
        }
        return $this->config;
    }

    public function setConfig($config)
    {
        if ($config instanceof Config) {
            $this->config = $config;
        } else {
            $this->config = new Config($config);
        }
        return $this;
    }

    public function addUser(User $user)
    {
        $this->config->addUser($user);
        return $this;
    }

    public function getUsers()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getUsers();
    }

    public function addGroup(Group $group)
    {
        $this->config->addGroup($group);
        return $this;
    }

    public function getGroups()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getGroups();
    }

    public function addRepository(Repository $repository)
    {
        $this->config->addRepository($repository);
        return $this;
    }

    public function getRepositories()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getRepositories();
    }
}
