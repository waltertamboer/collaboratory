<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Entity;

/**
 * The representation of a repository in Gitolite.
 */
class Repository
{
    /**
     * The name of the repository.
     *
     * @var string
     */
    private $name;

    /**
     * The list with users that are related to this repository.
     *
     * @var User[]
     */
    private $users;

    /**
     * The list with groups that are related to this repository.
     *
     * @var Group[]
     */
    private $groups;

    /**
     * Gets the name of the repository.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the repository.
     *
     * @param string $name The name of the repository to set.
     * @return Repository
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Adds the given user to this repository.
     *
     * @param User $user The user to add.
     * @return Repository
     */
    public function addUser(User $user)
    {
        $this->users[$user->getUsername()] = $user;
        return $this;
    }

    /**
     * Adds the given group to this repository.
     *
     * @param Group $group The group to add.
     * @return Repository
     */
    public function addGroup(Group $group)
    {
        $this->groups[$group->getName()] = $group;
        return $this;
    }
}
