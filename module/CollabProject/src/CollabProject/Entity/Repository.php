<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Entity;

class Repository
{
    /**
     * The id of the repository.
     *
     * @var int
     */
    private $id;

    /**
     * The name of the repository.
     *
     * @var string
     */
    private $name;

    /**
     * The description of the repository.
     *
     * @var string
     */
    private $description;

    /**
     * Gets the id of the repository.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the repository.
     *
     * @param int $id The id of the repository.
     * @return Repository
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @param string $name The name of the repository.
     * @return Repository
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Gets the description of the repository.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description of the repository.
     *
     * @param string $description The description of the repository.
     * @return Repository
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}
