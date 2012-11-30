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

use CollabTeam\Entity\Team;

class RepositoryTeam
{
    /**
     * The repository.
     *
     * @var Repository
     */
    private $repository;

    /**
     * The team.
     *
     * @var Team
     */
    private $team;

    /**
     * The permission.
     *
     * @var string
     */
    private $permission;

    /**
     * Gets the repository.
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the repository.
     *
     * @param Repository $repository The repository to set.
     * @return RepositoryTeam
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * Gets the team.
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Gets the team.
     *
     * @param Team $team The team to set.
     * @return RepositoryTeam
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * Gets the permission.
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Sets the permission.
     *
     * @param string $permission The permission to set.
     * @return RepositoryTeam
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }
}
