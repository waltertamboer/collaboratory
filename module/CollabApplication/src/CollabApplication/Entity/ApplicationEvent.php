<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Entity;

use DateTime;

class ApplicationEvent
{
    private $id;
    private $type;
    private $creationDate;
    private $parameters;

    public function __construct()
    {
        $this->creationDate = new DateTime();
        $this->parameters = array();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getParameter($name, $defaultValue = null)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        } else {
            return $defaultValue;
        }
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }
}
