<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Config;

use CollabGitolite\Entity\User;
use CollabGitolite\Entity\Group;
use CollabGitolite\Entity\Repository;

class Config
{
    private $users;
    private $groups;
    private $repositories;

    public function __construct($path = null)
    {
        $this->users = array();
        $this->groups = array();
        $this->repositories = array();

        if ($path) {
            $reader = new Reader();
            $reader->read($path, $this);
        }
    }

    public function addUser(User $user)
    {
        if (!$user->getUsername()) {
            throw new \Exception('The user does not have a username.');
        }

        $this->users[$user->getUsername()] = $user;
        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function addGroup(Group $group)
    {
        if (!$group->getName()) {
            throw new \Exception('The group does not have a name.');
        }

        $this->groups[$group->getName()] = $group;
        return $this;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function addRepository(Repository $repository)
    {
        if (!$repository->getName()) {
            throw new \Exception('The repository does not have a name.');
        }

        $this->repositories[$repository->getName()] = $repository;
        return $this;
    }

    public function getRepositories()
    {
        return $this->repositories;
    }
}
