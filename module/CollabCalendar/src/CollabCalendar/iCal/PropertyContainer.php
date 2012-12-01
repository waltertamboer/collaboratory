<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\iCal;

class PropertyContainer
{
    private $properties;

    public function __construct()
    {
        $this->properties = array();
    }

    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }
}
