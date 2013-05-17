<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Calendar;

class PropertyContainer
{
	/**
	 * A list with all properties.
	 * 
	 * @var array
	 */
    private $properties;

	/**
	 * Initializes a new instance of trhis 
	 */
    public function __construct()
    {
        $this->properties = array();
    }

	/**
	 * Sets the property.
	 * 
	 * @param Property $property The property to set.
	 */
    public function setProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }
}
