<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Entity;

class Property
{
    private $name;
    private $value;
    private $params;

    public function __construct($name, $value, array $params = array())
    {
        $this->name = $name;
        $this->value = $value;
        $this->params = $params;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getParam($name, $defaultValue = null)
    {
        if ($this->hasParam($name)) {
            return $this->params[$name];
        } else {
            return $defaultValue;
        }
    }
    
    public function hasParam($name)
    {
        return array_key_exists($name, $this->params);
    }
    
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }
}
