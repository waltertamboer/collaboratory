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
    'child_routes' => array(
        'users' => array(
            'type' => 'Zend\Mvc\Router\Http\Segment',
            'options' => array(
                'route' => '/users[/:id][.:formatter]',
                'constraints' => array(
                    'formatter' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[0-9]*'
                ),
                'defaults' => array(
                    'controller' => 'CollabUser\Controller\RestController',
                ),
            ),
        ),
    ),
);
