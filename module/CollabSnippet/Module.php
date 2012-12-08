<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSnippet;

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
                'CollabSnippet\Service\Logger' => 'CollabSnippet\Service\Logger',
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $eventManager->attachAggregate($sm->get('CollabSnippet\Service\Logger'));

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('snippet_create');
            $installer->addPermission('snippet_update');
            $installer->addPermission('snippet_delete');
        });

        $sharedManager->attach('CollabLayout', 'initializeMenu', function($e) {
            $layoutManager = $e->getTarget();
            $renderer = $layoutManager->getRenderer();

            $menuName = $e->getParam('name');
            $menu = $layoutManager->getMenu($menuName);

            if ($menuName == 'main') {
                $menu->insert(500, new MenuItem(500, 'Snippets', $renderer->url('snippet/overview')));
            }
        });
    }
}
