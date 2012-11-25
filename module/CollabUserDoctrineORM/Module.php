<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUserDoctrineORM;

use CollabSshDoctrineORM\Mapper\KeysMapper;
use CollabUserDoctrineORM\Mapper\PermissionMapper;
use CollabUserDoctrineORM\Mapper\UserMapper;
use CollabUserDoctrineORM\Validator\UniqueIdentity;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'collabuser.identityvalidator' => function($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');

                    return new UniqueIdentity($entityManager);
                },
                'CollabSsh\Mapper\KeysMapper' => function($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new KeysMapper($entityManager);
                },
                'collabuser.usermapper' => function($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new UserMapper($entityManager);
                },
                'CollabUser\Mapper\Permission' => function($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new PermissionMapper($entityManager);
                },
            ),
        );
    }
}
