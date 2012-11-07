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
            'Application\Controller\SnippetController' => 'Application\Controller\SnippetController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'dashboard' => array(
                'label' => 'News Feed',
                'route' => 'dashboard',
            ),
            'issue/overview' => array(
                'label' => 'Issues <span class="counter">0</span>',
                'route' => 'issue/overview',
            ),
            'project/overview' => array(
                'label' => 'Projects',
                'route' => 'project/overview',
            ),
            'team/overview' => array(
                'label' => 'Teams',
                'route' => 'team/overview',
            ),
            'snippet/overview' => array(
                'label' => 'Snippets',
                'route' => 'snippet/overview',
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
            'account' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account',
                    'defaults' => array(
                        'controller' => 'Application\Controller\AccountController',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'profile' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/profile',
                            'defaults' => array(
                                'action' => 'profile',
                            ),
                        ),
                    ),
                    'login' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'ssh' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/ssh',
                            'defaults' => array(
                                'action' => 'ssh',
                            ),
                        ),
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
            'issue' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/issues',
                    'defaults' => array(
                        'controller' => 'Application\Controller\IssueController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'overview' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/overview',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),
                        ),
                    ),
                ),
            ),
            'project' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/projects',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProjectController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'overview' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/overview',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Application\Controller\ProjectController',
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/update/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\ProjectController',
                                'action' => 'update',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\ProjectController',
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'team' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/teams',
                    'defaults' => array(
                        'controller' => 'Application\Controller\TeamController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'overview' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/overview',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/team/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'update',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/team/delete/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
            'snippet' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/snippets',
                    'defaults' => array(
                        'controller' => 'Application\Controller\SnippetController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'overview' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/overview',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/update/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'update',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                        ),
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
            'snippet.service' => 'Application\Service\SnippetServiceFactory',
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
