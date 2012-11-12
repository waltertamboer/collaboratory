<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUserDoctrineORM;

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
                'collabuser.usermapper' => function($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new UserMapper($entityManager);
                }
            ),
        );
    }
}
