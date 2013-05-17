<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendar;

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/screen.css' => array(
                    __NAMESPACE__ . '/sass/calendar.scss',
                ),
            ),
            'map' => array(
                __NAMESPACE__ . '/sass/calendar.scss' => __DIR__ . '/../public/sass/calendar.scss',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CollabCalendar\Controller\CalendarController' => 'CollabCalendar\Controller\CalendarController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'calendar/overview' => array(
                'label' => 'Calendar',
                'route' => 'calendar/overview',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'calendar' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/calendar',
                    'defaults' => array(
                        'controller' => 'CollabCalendar\Controller\CalendarController',
                        'action' => 'index',
                    ),
                ),
				'child_routes' => array(
					'overview' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/overview',
							'defaults' => array(
								'controller' => 'CollabCalendar\Controller\CalendarController',
								'action' => 'index',
							),
						),
					),
				),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'calendar.service' => 'CollabCalendar\Service\CalendarServiceFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
