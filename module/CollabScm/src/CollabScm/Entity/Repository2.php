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
class Repository extends AbstractEntity
{
    /**
     * The options of this repository.
     *
     * @var string[]
     */
    private $options;

    /**
     * A list with all entities and their access. This is a key/value list.
     *
     * @var string[]
     */
    private $accessList;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->options = array();
        $this->accessList = array();
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
	 * Clears the access list.
	 *
	 * @return Repository
	 */
	public function clearAccess()
	{
		$this->accessList = array();
		return $this;
	}

	/**
	 * Sets access for the given entity.
	 *
	 * @param AbstractEntity|string $entity The entity to set access for.
	 * @param Access $access The access to set.
	 * @return Repository
	 */
    public function setAccess($entity, Access $access)
    {
		if ($entity instanceof AbstractEntity) {
			$entity = $entity->getName();
		}
        $this->accessList[$entity] = $access;
        return $this;
    }

	/**
	 * Gets the access for the entity.
	 *
	 * @param AbstractEntity|string $entity The entity to get the access for.
	 * @return Repository
	 */
    public function getAccess($entity)
    {
		if ($entity instanceof AbstractEntity) {
			$entity = $entity->getName();
		}
        return isset($this->accessList[$entity]) ? $this->accessList[$entity] : null;
    }

	/**
	 * Gets the access list.
	 *
	 * @return Access[]
	 */
    public function getAccessList()
    {
        return $this->accessList;
    }

	/**
	 * Removes the acess for the given entity.
	 *
	 * @param AbstractEntity|string $group The entity to remove access for.
	 * @return Repository
	 */
	public function removeAccess($entity)
	{
		if ($entity instanceof AbstractEntity) {
			$entity = $entity->getName();
		}

		if (isset($this->accessList[$entity])) {
			unset($this->accessList[$entity]);
		}

		return $this;
	}
}
