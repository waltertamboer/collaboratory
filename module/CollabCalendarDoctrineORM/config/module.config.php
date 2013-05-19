<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabCalendarDoctrineORM;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../config/doctrine')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CollabCalendar\Entity' => __NAMESPACE__,
                )
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'calendar.mapper' => 'CollabCalendarDoctrineORM\Mapper\CalendarMapperFactory',
        ),
    ),
);
