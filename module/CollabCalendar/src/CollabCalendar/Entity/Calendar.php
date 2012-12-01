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

class Calendar
{
    private $id;
    private $name;
    private $events;

    public function __construct()
    {
        $this->events = array();
    }
}
