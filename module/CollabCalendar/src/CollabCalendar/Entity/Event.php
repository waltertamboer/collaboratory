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

class Event extends PropertyContainer implements EventInterface
{
	private $id;
	private $calendar;
	private $title;
	private $description;
    private $startDate;
    private $endDate;
    private $createdBy;
    private $createdOn;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar(Calendar $calendar)
    {
        if ($this->calendar != $calendar) {
            if ($this->calendar) {
                $this->calendar->removeEvent($this);
            }

            $this->calendar = $calendar;

            if ($this->calendar) {
                $this->calendar->addEvent($this);
            }
        }
    }
    
	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}
    
    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        if (!$startDate instanceof DateTime) {
            $startDate = new DateTime($startDate);
        }
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        if (!$endDate instanceof DateTime) {
            $endDate = new DateTime($endDate);
        }
        $this->endDate = $endDate;
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

    public function setCreatedOn($createdOn)
    {
        if (!$createdOn instanceof DateTime) {
            $createdOn = new DateTime($createdOn);
        }
        $this->createdOn = $createdOn;
    }
    
    public function occurs(DateTime $date)
    {
        return $this->startDate <= $date && $this->endDate >= $date;
    }
    
    public function occursOnDay(DateTime $date)
    {
        return $this->occurs($date);
    }
    
    public function occursInMonth(DateTime $date)
    {
        return $this->occurs($date);
    }
    
    public function occursInYear(DateTime $date)
    {
        return $this->occurs($date);
    }
}
