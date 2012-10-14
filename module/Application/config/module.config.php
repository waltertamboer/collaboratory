<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application;

return array(
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\DashboardController' => 'Application\Controller\DashboardController',
            'Application\Controller\TeamController' => 'Application\Controller\TeamController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'db' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/create/database',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'db',
                    ),
                ),
            ),
            'account' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
            'dashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
            'issueOverview' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/issues',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'issues',
                    ),
                ),
            ),
            'projectOverview' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/projects',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'projects',
                    ),
                ),
            ),
            'projectCreate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/project/create',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
            'teamOverview' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/teams',
                    'defaults' => array(
                        'controller' => 'Application\Controller\TeamController',
                        'action' => 'index',
                    ),
                ),
            ),
            'teamCreate' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/team/create',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\TeamController',
                        'action' => 'create',
                    ),
                ),
            ),
            'teamUpdate' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/team/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\TeamController',
                        'action' => 'update',
                    ),
                ),
            ),
            'teamDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/team/delete/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\TeamController',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'team.service' => 'Application\Service\TeamServiceFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
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
