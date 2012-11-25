<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmSvn;

use CollabProject\Entity\Repository;
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
        if ($repository->getType() == 'svn') {
            $this->createRepository($repository);
        }
    }

    public function createRepository(Repository $repository)
    {
        $project = $repository->getProject();

        $repoName = preg_replace('/[^a-z0-9-]+/i', '', strtolower($repository->getName()));
        $projectName = preg_replace('/[^a-z0-9-]+/i', '', strtolower($project->getName()));

        $path = getcwd() . '/data/projects/' . $project->getName() . '/repositories/' . $repoName;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $command = 'svnadmin create "' . $path . '"';
        exec($command);
    }
}
