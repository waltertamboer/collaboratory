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
        'route' => '/settings',
        'defaults' => array(
            'controller' => 'CollabUser\Controller\UserController',
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
    ),
);
