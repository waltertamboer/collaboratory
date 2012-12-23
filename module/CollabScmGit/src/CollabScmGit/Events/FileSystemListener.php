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

use CollabScm\Service\RepositoryService;
use CollabScmGit\Gitolite\Gitolite;
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
     * The gitolite manager.
     *
     * @var Gitolite
     */
    private $gitolite;

    /**
     * The repository service.
     *
     * @var RepositoryService
     */
    private $repositoryService;

    /**
     * Initializes a new instance of this class.
     * @param Gitolite $gitolite
     */
    public function __construct(Gitolite $gitolite, RepositoryService $repositoryService)
    {
        $this->gitolite = $gitolite;
        $this->repositoryService = $repositoryService;
    }

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
        $this->listeners[] = $sharedManager->attach('CollabScm', 'persist.post', array($this, 'onPersistRepository'));
        $this->listeners[] = $sharedManager->attach('CollabScm', 'remove.post', array($this, 'onRemoveRepository'));
        $this->listeners[] = $sharedManager->attach('CollabProject', 'remove.post', array($this, 'onRemoveProject'));
        $this->listeners[] = $sharedManager->attach('CollabTeam', 'persist.post', array($this, 'onPersistTeam'));
        $this->listeners[] = $sharedManager->attach('CollabTeam', 'remove.post', array($this, 'onRemoveTeam'));
        $this->listeners[] = $sharedManager->attach('CollabUser', 'persist.post', array($this, 'onPersistUser'));
        $this->listeners[] = $sharedManager->attach('CollabUser', 'remove.post', array($this, 'onRemoveUser'));
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

    public function onPersistRepository(Event $e)
    {
        $repository = $e->getParam('repository');
        if ($repository->getType() == 'git') {
            $this->gitolite->load();

            $oldName = $repository->getPreviousName();
            $newName = $repository->getName();

            if (!$e->getParam('isNew') && $oldName != $newName) {
                $this->gitolite->renameRepository($repository);
            }

            $this->gitolite->persist();
        }
    }

    public function onRemoveRepository(Event $e)
    {
        $repository = $e->getParam('repository');
        if ($repository->getType() == 'git') {
            $this->gitolite->load();
            $this->gitolite->persist();
            $this->gitolite->removeRepository($repository);
        }
    }

    public function onRemoveProject(Event $e)
    {
        // Get all the repositories for the project:
        $project = $e->getParam('project');
        $repositories = $this->repositoryService->findForProject($project);

        if (count($repositories)) {
            $this->gitolite->load();
            foreach ($repositories as $repository) {
                if ($repository->getType() == 'git') {
                    $this->gitolite->removeRepository($repository);
                }
            }
            $this->gitolite->persist();
        }
    }

    public function onPersistTeam(Event $e)
    {
        $this->gitolite->load();
        $this->gitolite->persist();
    }

    public function onRemoveTeam(Event $e)
    {
        $this->gitolite->load();
        $this->gitolite->persist();
    }

    public function onPersistUser(Event $e)
    {
        $this->gitolite->load();
        $this->gitolite->persist();
    }

    public function onRemoveUser(Event $e)
    {
        $this->gitolite->load();
        $this->gitolite->persist();
    }
}
