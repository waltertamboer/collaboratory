<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Calendar\Reader;

use CollabCalendar\Calendar\Calendar;

interface ReaderInterface
{
	/**
	 * Reads a calendar from a data source.
	 * 
	 * @return Calendar
	 */
	public function read();
}
