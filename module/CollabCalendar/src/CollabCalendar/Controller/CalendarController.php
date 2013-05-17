<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CalendarController extends AbstractActionController
{
    public function indexAction()
    {
		$url = 'https://www.google.com/calendar/ical/walter.tamboer%40gmail.com/private-fafcabe34162fe4fbb676d7b27ccc011/basic.ics';
		
		$reader = new \CollabCalendar\Calendar\Reader\ICal\Reader();
		$reader->setUrl($url);
		$calendar = $reader->read();
		
		var_dump($calendar);
		exit;
		
        return new ViewModel();
    }
}
