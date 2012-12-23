<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmGit;

use CollabScmGit\Gitolite\Gitolite;
use CollabScmGit\Events\FileSystemListener;

class Module
{

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CollabScmGit\Gitolite' => function($sm) {
                    $adminPath = realpath('data') . DIRECTORY_SEPARATOR . 'gitolite-admin';
                    $storagePath = '/home/git/';

                    $instance = new Gitolite('git@localhost:gitolite-admin', $adminPath, $storagePath);
                    $instance->setRepositoryService($sm->get('CollabScm\Service\Repository'));
                    return $instance;
                },
                'CollabScmGit\Events\FileSystemListener' => function($sm) {
                    $gitolite = $sm->get('CollabScmGit\Gitolite');
                    $repositoryService = $sm->get('CollabScm\Service\Repository');
                    return new FileSystemListener($gitolite, $repositoryService);
                }
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $eventManager->attachAggregate($sm->get('CollabScmGit\Events\FileSystemListener'));
    }

}
