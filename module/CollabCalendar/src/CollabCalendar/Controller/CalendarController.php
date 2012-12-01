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

use CollabCalendar\iCal\Reader;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CalendarController extends AbstractActionController
{
    public function indexAction()
    {
        $address = 'https://www.google.com/calendar/ical/walter.tamboer%40gmail.com/private-fafcabe34162fe4fbb676d7b27ccc011/basic.ics';

        $reader = new Reader();
        $calendar = $reader->readFromUrl($address);

        echo '<pre>';
        print_r($calendar);
        exit;
        return new ViewModel();
    }

}
