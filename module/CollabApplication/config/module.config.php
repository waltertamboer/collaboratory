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
                'css/screen.css' => array(
                    __NAMESPACE__ . '/sass/reset.scss',
                    __NAMESPACE__ . '/sass/alerts.scss',
                    __NAMESPACE__ . '/sass/boxed-groups.scss',
                    __NAMESPACE__ . '/sass/grid.scss',
                    __NAMESPACE__ . '/sass/buttons.scss',
                    __NAMESPACE__ . '/sass/form.scss',
                    __NAMESPACE__ . '/sass/dialog.scss',
                    __NAMESPACE__ . '/sass/navigation.scss',
                    __NAMESPACE__ . '/sass/nav-accordion.scss',
                    __NAMESPACE__ . '/sass/layout.scss',
                ),
            ),
            'map' => array(
                'js/jquery-1.8.3.min.js' => __DIR__ . '/../public/js/jquery-1.8.3.min.js',
                __NAMESPACE__ . '/sass/reset.scss' => __DIR__ . '/../public/sass/reset.scss',
                __NAMESPACE__ . '/sass/alerts.scss' => __DIR__ . '/../public/sass/alerts.scss',
                __NAMESPACE__ . '/sass/boxed-groups.scss' => __DIR__ . '/../public/sass/boxed-groups.scss',
                __NAMESPACE__ . '/sass/grid.scss' => __DIR__ . '/../public/sass/grid.scss',
                __NAMESPACE__ . '/sass/buttons.scss' => __DIR__ . '/../public/sass/buttons.scss',
                __NAMESPACE__ . '/sass/form.scss' => __DIR__ . '/../public/sass/form.scss',
                __NAMESPACE__ . '/sass/navigation.scss' => __DIR__ . '/../public/sass/navigation.scss',
                __NAMESPACE__ . '/sass/nav-accordion.scss' => __DIR__ . '/../public/sass/nav-accordion.scss',
                __NAMESPACE__ . '/sass/dialog.scss' => __DIR__ . '/../public/sass/dialog.scss',
                __NAMESPACE__ . '/sass/layout.scss' => __DIR__ . '/../public/sass/layout.scss',
            ),
        ),
        'filters' => array(
            'css/screen.css' => array(
                array(
                    'service' => 'CollabApplication\Service\SassFilterFactory',
                ),
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
