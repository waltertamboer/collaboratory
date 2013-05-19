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
        $calendarService = $this->getServiceLocator()->get('calendar.service');
        
        return new ViewModel(array(
            'calendars' => $calendarService->findAll(),
        ));
    }
    
    public function yearAction()
    {
        $calendarService = $this->getServiceLocator()->get('calendar.service');

        return new ViewModel(array(
            'calendars' => $calendarService->findAll(),
        ));
    }
    
    public function monthAction()
    {
        $calendarService = $this->getServiceLocator()->get('calendar.service');

        return new ViewModel(array(
            'calendars' => $calendarService->findAll(),
        ));
    }
    
    public function dayAction()
    {
        $calendarService = $this->getServiceLocator()->get('calendar.service');

        return new ViewModel(array(
            'calendars' => $calendarService->findAll(),
        ));
    }
    
    public function eventsAction()
    {
        $calendarService = $this->getServiceLocator()->get('calendar.service');

        return new ViewModel(array(
            'calendars' => $calendarService->findAll(),
        ));
    }
}
