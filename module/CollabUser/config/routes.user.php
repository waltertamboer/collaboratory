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
    'type' => 'Zend\Mvc\Router\Http\Literal',
    'options' => array(
        'route' => '/user',
        'defaults' => array(
            'controller' => 'CollabUser\Controller\UserController',
        ),
    ),
    'may_terminate' => false,
    'child_routes' => array(
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
        'request-password' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/request/password',
                'defaults' => array(
                    'action' => 'request-password',
                ),
            ),
        ),
    ),
);
