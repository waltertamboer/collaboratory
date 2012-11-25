<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject\Events;

use CollabApplication\Events\ApplicationEventsAwareInterface;
use CollabApplication\Service\ApplicationEvents;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class RepositoryLogger implements ListenerAggregateInterface, ApplicationEventsAwareInterface
{
    /**
     * The application events manager.
     *
     * @var ApplicationEvents
     */
    private $applicationEvents;

    /**
     * @var CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        $this->listeners[] = $sharedManager->attach('CollabScm', 'persist.post', array($this, 'onPersistPost'));
        $this->listeners[] = $sharedManager->attach('CollabScm', 'remove.post', array($this, 'onRemovePost'));
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        foreach ($this->listeners as $index => $listener) {
            if ($sharedManager->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function setApplicationEvents(ApplicationEvents $applicationEvents)
    {
        $this->applicationEvents = $applicationEvents;
    }

    public function onPersistPost(Event $e)
    {
    }

    public function onRemovePost(Event $e)
    {
    }

}
