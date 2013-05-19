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

use CollabUser\Entity\User;
use DateTime;

class Calendar extends PropertyContainer implements CalendarInterface
{
    /**
     * The id of the calendar in the storage device.
     * 
     * @var int
     */
    private $id;
    
    /**
     * The data type of this calendar. This determines how the events get loaded.
     * 
     * @var string
     */
    private $dataType;
    
    /**
     * The data source of this calendar. The source to load the events from.
     * 
     * @var string
     */
    private $dataSource;
    
	/**
	 * The title of the calendar.
	 * 
	 * @var string
	 */
    private $title;
    
	/**
	 * The description of the calendar.
	 * 
	 * @var string
	 */
    private $description;
	
    /**
     * The color that identifies the calendar.
     * 
     * @var string
     */
    private $color;
    
	/**
	 * A list with all calendar events.
	 * 
	 * @var EventInterface[]
	 */
    private $events;
    
    /**
     * The user that created the calendar.
     * 
     * @var User
     */
    private $createdBy;
    
    /**
     * The date and time of when the calendar was created.
     * 
     * @var DateTime
     */
    private $createdOn;

	/**
	 * Initializes a new instance of this class.
	 */
    public function __construct()
    {
        $this->events = array();
    }

    /**
     * Gets the id of the calendar.
     * 
     * @return int
     */
	public function getId()
	{
		return $this->id;
	}

    /**
     * Sets the id of the calendar.
     * 
     * @param int $id The id to set.
     */
	public function setId($id)
	{
		$this->id = $id;
	}
    
    /**
     * Gets the data type of this calendar.
     * 
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Sets the data type of this calendar.
     * 
     * @param string $dataType The data type to set.
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }
    
    /**
     * Gets the data source of this calendar.
     * 
     * @return string
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Sets the data source of this calendar.
     * 
     * @param string $dataSource The data source to set.
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }
    
	/**
	 * Gets the title of the calendar.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Sets the title of the calendar.
	 * 
	 * @param string $title The title of the calendar to set.
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
    
    /**
     * Gets the description of the calendar.
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description of the calendar.
     * 
     * @param string $description The description of the calendar.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Gets the color of the calendar.
     * 
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the color of the calendar.
     * 
     * @param string $color The color to set.
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
	
	/**
	 * Adds an event to the calendar.
	 * 
	 * @param EventInterface $event The event to add.
	 */
	public function addEvent(EventInterface $event)
	{
        if (!in_array($event, $this->events)) {
            $this->events[] = $event;
            $event->setCalendar($this);
        }
	}
    
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setCreatedOn(DateTime $createdOn)
    {
        if (!$createdOn instanceof DateTime) {
            $createdOn = new DateTime($createdOn);
        }
        $this->createdOn = $createdOn;
    }
    
    /**
     * Finds all events that happen on the day of the given date and time.
     * 
     * @param DateTime $dateTime The date and time to calculate with.
     * @return EventInterface[]
     */
    public function findEventsOnDay(DateTime $dateTime)
    {
        $result = array();
        foreach ($this->events as $event) {
            if ($event->occursOnDay($dateTime)) {
                $result[] = $event;
            }
        }
        return $result;
    }
}
