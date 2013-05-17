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

/**
 * The representation of a calendar.
 */
class Calendar extends PropertyContainer
{
	/**
	 * The name of the calendar.
	 * 
	 * @var string
	 */
    private $name;
	
	/**
	 * A list with all calendar events.
	 * 
	 * @var EventInterface[]
	 */
    private $events;

	/**
	 * Initializes a new instance of this class.
	 */
    public function __construct()
    {
        $this->events = array();
    }

	/**
	 * Gets the name of the calendar.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the name of the calendar.
	 * 
	 * @param string $name The name of the calendar to set.
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Adds an event to the calendar.
	 * 
	 * @param EventInterface $event The event to add.
	 */
	public function addEvent(EventInterface $event)
	{
		$this->events[] = $event;
	}
}
