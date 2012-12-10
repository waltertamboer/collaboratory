<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser;

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/screen.css' => array(
                    __NAMESPACE__ . '/sass/login.scss',
                ),
            ),
            'map' => array(
                __NAMESPACE__ . '/sass/login.scss' => __DIR__ . '/../public/sass/login.scss',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CollabSsh\Controller\KeysController' => 'CollabSsh\Controller\KeysController',
            'CollabUser\Controller\AccountController' => 'CollabUser\Controller\AccountController',
            'CollabUser\Controller\UserController' => 'CollabUser\Controller\UserController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'user/overview' => array(
                'label' => 'Users',
                'route' => 'account/overview',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'account' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/account',
                    'defaults' => array(
                        'controller' => 'CollabUser\Controller\AccountController',
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
            'ssh' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/ssh',
                    'defaults' => array(
                        'controller' => 'CollabSsh\Controller\KeysController',
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
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'CollabUser\Controller\UserController',
                        'action' => 'profile',
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
                    'logout' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'action' => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
