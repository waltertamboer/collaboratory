<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmGit\Events;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class FileSystemListener implements ListenerAggregateInterface
{
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

    public function onPersistPost(Event $e)
    {
        $repository = $e->getParam('repository');
        if ($repository->getType() == 'git' && $e->getParam('shouldInitialize')) {
            $path = realpath($e->getParam('repositoryPath'));

            // Create the repository:
            $command = 'git --bare init "' . $path . '"';
            exec($command);

            // Since the httpd user created the apache, we need to make sure that
            // permissions are set correct:
            exec('chmod -R 0777 "' . $path . '"');
        }
    }
}
