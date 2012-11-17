<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Entity;

/**
 * The representation of a Gitolite group.
 */
class Group
{
    /**
     * The name of the group.
     *
     * @var string
     */
    private $name;

    /**
     * The users in this group.
     *
     * @var User[]
     */
    private $users;

    /**
     * Gets the name of the group.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the group.
     *
     * @param string $name The name of the group to set.
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Adds the given user to this group.
     *
     * @param User $user The user to add.
     * @return Group
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
        return $this;
    }

    /**
     * Clears all the users in this group.
     *
     * @return Group
     */
    public function clearUsers()
    {
        $this->users = array();
        return $this;
    }

    /**
     * Gets all the users in this group.
     *
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
