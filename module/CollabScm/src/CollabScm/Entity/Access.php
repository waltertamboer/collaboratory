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
 * The access that a user or group can have to a repository.
 */
class Access
{
	/** Permission denied. */
    const DENY = 0;

	/** Permission to read. */
    const READ = 1;

	/** Permission to write. */
    const WRITE = 2;

    /**
     * The permission.
     *
     * @var string
     */
    private $permission;

	/**
	 * Initializes a new instance of this class.
	 *
	 * @param int $permission The permission to set.
	 */
    public function __construct($permission)
    {
        $this->permission = $permission;
    }

	/**
	 * Gets the permission level.
	 *
	 * @return int
	 */
    public function getPermission()
    {
        return $this->permission;
    }

	/**
	 * Sets the permission level.
	 *
	 * @param int $permission The permission to set.
	 * @return Access
	 */
    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

	/**
	 * A helper function to see if the given permission is allowed.
	 *
	 * @param int $permission The permission to check for.
	 * @return bool
	 */
	public function isAllowed($permission)
	{
		return ($this->permission & $permission) == $permission;
	}

	/**
	 * A helper function to deny all permissions.
	 *
	 * @return Access
	 */
	public function deny()
	{
		$this->permission = self::DENY;
		return $this;
	}

	/**
	 * A helper function to allow a permission (or not).
	 *
	 * @param int $permission The permission to allow.
	 * @param bool $allowed Whether or not the permission is set.
	 * @return Access
	 */
	public function setAllowed($permission, $allowed = true)
	{
		if ($allowed) {
			$this->permission |= $permission;
		} else {
			$this->permission &= ~$permission;
		}
		return $this;
	}
}
