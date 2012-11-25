<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm;

return array(
    'service_manager' => array(
        'invokables' => array(
            'CollabScm\Service\Synchronizer' => 'CollabScm\Service\Synchronizer'
        ),
    ),
    'router' => array(
        'routes' => array(
            'scm' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/scm',
                    'defaults' => array(
                        'controller' => 'CollabScm\Controller\RepositoryController',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'create' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/create/:project',
                            'constraints' => array(
                                'project' => '[0-9]+',
                            ),
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
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
