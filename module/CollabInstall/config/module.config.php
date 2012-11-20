<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall;

return array(
    'controllers' => array(
        'invokables' => array(
            'CollabInstall\Controller\InstallController' => 'CollabInstall\Controller\InstallController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'install' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/install',
                    'defaults' => array(
                        'controller' => 'CollabInstall\Controller\InstallController',
                        'action' => 'index',
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
