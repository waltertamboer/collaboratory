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

class Calendar extends PropertyContainer
{
    private $events;

    public function __construct()
    {
        $this->events = array();
    }

    public function addEvent(Event $event)
    {
        $this->events[] = $event;
        return $this;
    }
}
