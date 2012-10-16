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
            'Application\Controller\AccountController' => 'Application\Controller\AccountController',
            'Application\Controller\DashboardController' => 'Application\Controller\DashboardController',
            'Application\Controller\IssueController' => 'Application\Controller\IssueController',
            'Application\Controller\TeamController' => 'Application\Controller\TeamController',
            'Application\Controller\ProjectController' => 'Application\Controller\ProjectController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'home' => array(
                'label' => 'News Feed',
                'route' => 'dashboard',
            ),
            'login' => array(
                'label' => 'Issues <span class="counter">0</span>',
                'route' => 'issueOverview',
            ),
            'logout' => array(
                'label' => 'Projects',
                'route' => 'projectOverview',
            ),
            'register' => array(
                'label' => 'Teams',
                'route' => 'teamOverview',
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
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'db',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\DashboardController',
                        'action' => 'index',
                    ),
                ),
            ),
            'accountProfile' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account/profile',
                    'defaults' => array(
                        'controller' => 'Application\Controller\AccountController',
                        'action' => 'profile',
                    ),
                ),
            ),
            'accountLogin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\AccountController',
                        'action' => 'login',
                    ),
                ),
            ),
            'accountSsh' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account/ssh',
                    'defaults' => array(
                        'controller' => 'Application\Controller\AccountController',
                        'action' => 'ssh',
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
                        'controller' => 'Application\Controller\IssueController',
                        'action' => 'index',
                    ),
                ),
            ),
            'projectOverview' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/projects',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProjectController',
                        'action' => 'index',
                    ),
                ),
            ),
            'projectCreate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/project/create',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProjectController',
                        'action' => 'create',
                    ),
                ),
            ),
            'projectUpdate' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/project/update/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProjectController',
                        'action' => 'update',
                    ),
                ),
            ),
            'projectDelete' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/project/delete/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProjectController',
                        'action' => 'delete',
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
            'navigation/main' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'team.service' => 'Application\Service\TeamServiceFactory',
            'project.service' => 'Application\Service\ProjectServiceFactory',
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
