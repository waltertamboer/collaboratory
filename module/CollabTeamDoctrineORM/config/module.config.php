<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeamDoctrineORM;

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
                    'CollabTeam\Entity' => __NAMESPACE__
                )
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'team.mapper' => 'CollabTeamDoctrineORM\Mapper\TeamMapperFactory',
        ),
    ),
);
