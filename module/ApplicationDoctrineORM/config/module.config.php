<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace ApplicationDoctrineORM;

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
                    'Application\Entity' => __NAMESPACE__
                )
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'team.mapper' => 'ApplicationDoctrineORM\Mapper\TeamMapperFactory',
            'project.mapper' => 'ApplicationDoctrineORM\Mapper\ProjectMapperFactory',
            'snippet.mapper' => 'ApplicationDoctrineORM\Mapper\SnippetMapperFactory',
            'ssh.mapper' => 'ApplicationDoctrineORM\Mapper\SshMapperFactory',
        ),
    ),
);
