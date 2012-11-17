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

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'application/css/layout.css' => array(
                    'application/css/base.css',
                    'application/css/data-list.css',
                    'application/css/forms.css',
                    'application/css/menu-tabs.css',
                    'application/css/news.css',
                    'application/css/tips.css',
                ),
                'application/css/layout-responsive.css' => array(
                    'application/css/base-responsive.css',
                ),
            ),
            'map' => array(
                'application/css/base.css' => __DIR__ . '/../public/css/base.css',
                'application/css/base-responsive.css' => __DIR__ . '/../public/css/base-responsive.css',
                'application/css/data-list.css' => __DIR__ . '/../public/css/data-list.css',
                'application/css/forms.css' => __DIR__ . '/../public/css/forms.css',
                'application/css/menu-tabs.css' => __DIR__ . '/../public/css/menu-tabs.css',
                'application/css/news.css' => __DIR__ . '/../public/css/news.css',
                'application/css/tips.css' => __DIR__ . '/../public/css/tips.css',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CollabApplication\Controller\DashboardController' => 'CollabApplication\Controller\DashboardController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'dashboard' => array(
                'label' => 'News Feed',
                'route' => 'dashboard',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'db' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/create/database',
                    'defaults' => array(
                        'controller' => 'CollabApplication\Controller\DashboardController',
                        'action' => 'db',
                    ),
                ),
            ),
            'dashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'CollabApplication\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation/main' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/empty' => __DIR__ . '/../view/layout/empty.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
