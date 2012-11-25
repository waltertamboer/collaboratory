<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProject;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'CollabProject\Events\ProjectLogger' => 'CollabProject\Events\ProjectLogger',
                'CollabProject\Events\RepositoryLogger' => 'CollabProject\Events\RepositoryLogger',
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $eventManager->attachAggregate($sm->get('CollabProject\Events\ProjectLogger'));
        $eventManager->attachAggregate($sm->get('CollabProject\Events\RepositoryLogger'));

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall\Service\Installer', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('project_create');
            $installer->addPermission('project_update');
            $installer->addPermission('project_delete');
            $installer->addPermission('repository_create');
            $installer->addPermission('repository_update');
            $installer->addPermission('repository_delete');
        });
    }
}
