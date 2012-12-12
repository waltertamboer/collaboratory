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
);
