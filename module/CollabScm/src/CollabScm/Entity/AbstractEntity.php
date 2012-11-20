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
 * The base class for all entities.
 */
abstract class AbstractEntity
{
    /**
     * The name of the entity.
     *
     * @var string
     */
    private $name;

    /**
     * The entities that are children of this entity.
     *
     * @var AbstractEntity[]
     */
    private $entities;

	/**
	 * Initializes a new instance of this class.
	 */
	public function __construct()
	{
		$this->entities = array();
	}

    /**
     * Gets the name of the entity.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the raw name of the entity.
     *
     * @return string
     */
    public function getRawName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the entity.
     *
     * @param string $name The name of the entity to set.
     * @return AbstractEntity
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
	 * Adds the given entity.
	 *
	 * @param AbstractEntity $entity The entity to add.
	 * @return AbstractEntity
	 */
    public function addEntity(AbstractEntity $entity)
    {
        $this->entities[$entity->getName()] = $entity;
        return $this;
    }

	/**
	 * Clears all the entities.
	 *
	 * @return AbstractEntity
	 */
	public function clearEntities()
	{
		$this->entities = array();
		return $this;
	}

	/**
	 * Gets the entity with the given name.
	 *
	 * @param string $name The name of the entity.
	 * @return AbstractEntity
	 */
    public function getEntity($name)
    {
        return isset($this->entities[$name]) ? $this->entities[$name] : null;
    }

	/**
	 * Gets all the entities.
	 *
	 * @return AbstractEntity[]
	 */
    public function getEntities()
    {
        return $this->entities;
    }

	/**
	 * Removes the given entity.
	 *
	 * @param AbstractEntity|string $entity
	 * @return AbstractEntity
	 */
	public function removeEntity($entity)
	{
		if ($entity instanceof AbstractEntity) {
			$entity = $entity->getName();
		}

		if (isset($this->entities[$entity])) {
			unset($this->entities[$entity]);
		}

		return $this;
	}
}
