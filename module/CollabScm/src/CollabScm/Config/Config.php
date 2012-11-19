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

use CollabScm\Entity\User;
use CollabScm\Entity\Group;
use CollabScm\Entity\Repository;

class Config
{
    /**
     * A list with regular expressions that match users.
     *
     * @var string[]
     */
    private $users;

    /**
     * A list with regular expressions that match repositories.
     *
     * @var string[]
     */
    private $repositories;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->users = array();
        $this->repositories = array();
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
