<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam;

use CollabApplication\Layout\Menu\MenuItem;

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
                'CollabTeam\Events\Logger' => 'CollabTeam\Events\Logger',
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'canCreateTeam' => function ($sm) {
                    $sl = $sm->getServiceLocator();

                    $viewHelper = new View\Helper\CanCreateTeam();
                    $viewHelper->setAccess($sl->get('CollabUser\Access'));
                    return $viewHelper;
                },
                'canUpdateTeam' => function ($sm) {
                    $sl = $sm->getServiceLocator();

                    $viewHelper = new View\Helper\CanUpdateTeam();
                    $viewHelper->setAccess($sl->get('CollabUser\Access'));
                    return $viewHelper;
                },
                'canRemoveTeam' => function ($sm) {
                    $sl = $sm->getServiceLocator();

                    $viewHelper = new View\Helper\CanRemoveTeam();
                    $viewHelper->setAccess($sl->get('CollabUser\Access'));
                    return $viewHelper;
                }
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $eventManager->attachAggregate($sm->get('CollabTeam\Events\Logger'));

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('team_create');
            $installer->addPermission('team_update');
            $installer->addPermission('team_delete');
        });

        $sharedManager->attach('CollabLayout', 'initializeMenu', function($e) {
            $layoutManager = $e->getTarget();
            $renderer = $layoutManager->getRenderer();

            $menuName = $e->getParam('name');
            $menu = $layoutManager->getMenu($menuName);

            if ($menuName == 'main') {
                $menu->insert(200, new MenuItem(200, 'Teams', $renderer->url('team/overview')));
            }
        });
    }

}
