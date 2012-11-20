<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Config;

use CollabScm\Entity\Group;
use CollabScm\Entity\Repository;
use CollabScm\Entity\User;

class Config
{
	/**
     * A list with groups that exist.
     *
     * @var string[]
     */
    private $groups;

    /**
     * A list with users that exist.
     *
     * @var string[]
     */
    private $users;

    /**
     * A list with repositories that exist.
     *
     * @var string[]
     */
    private $repositories;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->groups = array();
        $this->users = array();
        $this->repositories = array();
    }

	/**
	 * Adds the given group.
	 *
	 * @param Group $group The group to add.
	 * @return Config
	 */
    public function addGroup(Group $group)
    {
        $this->groups[$group->getRawName()] = $group;
        return $this;
    }

	/**
	 * Clears all the groups.
	 *
	 * @return Config
	 */
	public function clearGroups()
	{
		$this->groups = array();
		return $this;
	}

	/**
	 * Gets a group by the given name.
	 *
	 * @param string $name The name of the group to get.
	 * @return Config
	 */
    public function getGroup($name)
    {
        return isset($this->groups[$name]) ? $this->groups[$name] : null;
    }

	/**
	 * Gets all the groups.
	 *
	 * @return Group[]
	 */
    public function getGroups()
    {
        return $this->groups;
    }

	/**
	 * Removes the given group.
	 *
	 * @param string $group The group to remove.
	 * @return Config
	 */
	public function removeGroup($group)
	{
		if ($group instanceof Group) {
			$group = $group->getName();
		}

		if (isset($this->groups[$group])) {
			unset($this->groups[$group]);
		}

		return $this;
	}

	/**
	 * Adds the given repository.
	 *
	 * @param Repository $repository The repository to add.
	 * @return Config
	 */
    public function addRepository(Repository $repository)
    {
        $this->repositories[$repository->getName()] = $repository;
        return $this;
    }

	/**
	 * Clears all the repositories.
	 *
	 * @return Config
	 */
	public function clearRepositories()
	{
		$this->repositories = array();
		return $this;
	}

	/**
	 * Gets all the repositories.
	 *
	 * @return Repository[]
	 */
    public function getRepositories()
    {
        return $this->repositories;
    }

	/**
	 * Removes the given repository.
	 *
	 * @param Repository|string $repository The repository to remove.
	 * @return Config
	 */
	public function removeRepository($repository)
	{
		if ($repository instanceof Repository) {
			$repository = $repository->getName();
		}

		if (isset($this->repositories[$repository])) {
			unset($this->repositories[$repository]);
		}

		return $this;
	}

	/**
	 * Adds the given user.
	 *
	 * @param User $user The user to add.
	 * @return Config
	 */
    public function addUser(User $user)
    {
        $this->users[$user->getRawName()] = $user;
        return $this;
    }

	/**
	 * Clears all the users.
	 *
	 * @return Config
	 */
	public function clearUsers()
	{
		$this->users = array();
		return $this;
	}

	/**
	 * Gets the user with the given name.
	 *
	 * @param string $name The name of the user.
	 * @return Config
	 */
    public function getUser($name)
    {
        return isset($this->users[$name]) ? $this->users[$name] : null;
    }

	/**
	 * Gets all the users.
	 *
	 * @return User[]
	 */
    public function getUsers()
    {
        return $this->users;
    }

	/**
	 * Removes the given user.
	 *
	 * @param User|string $user
	 * @return Config
	 */
	public function removeUser($user)
	{
		if ($user instanceof User) {
			$user = $user->getName();
		}

		if (isset($this->users[$user])) {
			unset($this->users[$user]);
		}

		return $this;
	}
}
