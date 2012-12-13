<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication;

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
            'factories' => array(
                'navigation/main' => 'Zend\Navigation\Service\DefaultNavigationFactory',
                'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
                'CollabApplication\Service\SassFilterFactory' => 'CollabApplication\Service\SassFilterFactory',
                'CollabApplication\Service\ApplicationEvents' => function($sm) {
                    $mapper = $sm->get('CollabApplication\Mapper\ApplicationEvents');
                    return new Service\ApplicationEvents($mapper);
                },
                'CollabApplication\Layout\LayoutManager' => function($sm) {
                    $renderer = $sm->get('viewrenderer');
                    return new Layout\LayoutManager($renderer);
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'renderApplicationEvent' => function ($sm) {
                    return new View\Helper\RenderApplicationEvent();
                },
                'collabMenu' => function ($sm) {
                    $layoutManager = $sm->getServiceLocator()->get('CollabApplication\Layout\LayoutManager');
                    return new View\Helper\CollabMenu($layoutManager);
                },
                'formAutocomplete' => function ($sm) {
                    return new Form\View\Helper\FormAutocomplete();
                },
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $applicationEvents = $sm->get('CollabApplication\Service\ApplicationEvents');

        $sm->addInitializer(function($class) use ($applicationEvents) {
            if ($class instanceof Events\ApplicationEventsAwareInterface) {
                $class->setApplicationEvents($applicationEvents);
            }
        });

        $eventManager = $application->getEventManager();

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabLayout', 'initializeMenu', function($e) {
            $layoutManager = $e->getTarget();
            $renderer = $layoutManager->getRenderer();

            $menuName = $e->getParam('name');
            $menu = $layoutManager->getMenu($menuName);

            if ($menuName == 'main') {
                $menu->insert(0, new MenuItem(0, 'Dashboard', $renderer->url('dashboard')));
            }
        });
    }
}
