<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Service;

use CollabCalendar\Entity\Calendar;
use CollabCalendar\Mapper\CalendarMapperInterface;

class CalendarService
{
    private $mapper;
    
    public function __construct(CalendarMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }
    
    public function findAll()
    {
        return $this->mapper->findAll();
    }

    public function persist(Calendar $calendar)
    {
        $this->mapper->persist($calendar);
        return $this;
    }

    public function remove(Calendar $calendar)
    {
        $this->mapper->remove($calendar);
        return $this;
    }
}
