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
				'may_terminate' => true,
				'child_routes' => array(
					'database' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/database',
							'defaults' => array(
								'action' => 'database',
							),
						),
					),
					'account' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/account',
							'defaults' => array(
								'action' => 'account',
							),
						),
					),
					'finish' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/finish',
							'defaults' => array(
								'action' => 'finish',
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
