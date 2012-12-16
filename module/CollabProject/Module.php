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

use CollabApplication\Layout\Menu\MenuItem;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'CollabProject\Controller\ProjectController' => 'CollabProject\Controller\ProjectController',
                'CollabProject\Controller\RestController' => 'CollabProject\Controller\RestController',
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'CollabProject\Events\ProjectLogger' => 'CollabProject\Events\ProjectLogger',
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $eventManager->attachAggregate($sm->get('CollabProject\Events\ProjectLogger'));

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('project_create');
            $installer->addPermission('project_update');
            $installer->addPermission('project_delete');
        });

        $sharedManager->attach('CollabLayout', 'initializeMenu', function($e) {
            $layoutManager = $e->getTarget();
            $renderer = $layoutManager->getRenderer();

            $menuName = $e->getParam('name');
            $menu = $layoutManager->getMenu($menuName);

            if ($menuName == 'main') {
                $menu->insert(300, new MenuItem(300, 'Projects', $renderer->url('project/overview')));
            }
        });
    }
}
