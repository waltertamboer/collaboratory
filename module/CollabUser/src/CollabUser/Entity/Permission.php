<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Entity;

class Permission
{
    /**
     * The id of the permission.
     *
     * @var int
     */
    private $id;

    /**
     * The name of the permission.
     *
     * @var string
     */
    private $name;

    /**
     * The teams that have this permission.
     *
     * @var Team
     */
    private $teams;

    /**
     * Gets the id of the permission.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the name of the permission.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the permission.
     *
     * @param string $name The name to set.
     * @return Permission
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the teams that have this permission.
     *
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Sets the teams that have the permission.
     *
     * @param Team[] $teams The teams to set.
     * @return Permission
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
        return $this;
    }
}
