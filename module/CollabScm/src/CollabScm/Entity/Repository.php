<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Entity;

/**
 * The representation of a repository.
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
     * The options of this repository.
     *
     * @var string[]
     */
    private $options;

    /**
     * The list with users that are related to this repository.
     *
     * @var User[]
     */
    private $users;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->options = array();
        $this->users = array();
    }

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
     * Gets the options of the repository.
     *
     * @return string[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the option in the repository.
     *
     * @param string $name The name of the option to set.
     * @param string $value The value of the option to set.
     * @return Repository
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     * Adds the given user to this repository.
     *
     * @param User $user The user to add.
     * @param Access $access The access that the user has.
     * @return Repository
     */
    public function addUser(User $user, Access $access)
    {
        $this->users[$user->getUsername()] = $access;
        return $this;
    }

    /**
     * Gets the users that are related to this repository.
     *
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
