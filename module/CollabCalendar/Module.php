<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar;

use CollabApplication\Layout\Menu\MenuItem;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'calendar' => 'CollabCalendar\View\Helper\Calendar',
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('calendar_create');
            $installer->addPermission('calendar_update');
            $installer->addPermission('calendar_delete');
        });

        $sharedManager->attach('CollabLayout', 'initializeMenu', function($e) {
            $layoutManager = $e->getTarget();
            $renderer = $layoutManager->getRenderer();

            $menuName = $e->getParam('name');
            $menu = $layoutManager->getMenu($menuName);

            if ($menuName == 'main') {
                $menu->insert(400, new MenuItem(400, 'Calendar', $renderer->url('calendar/overview')));
            }
        });
    }
}
