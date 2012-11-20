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

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

//    public function onBootstrap($e)
//    {
//        $path = __DIR__ . '/collaboratory.json';
//
//        $sm = $e->getApplication()->getServiceManager();
//        $synchronizer = $sm->get('CollabScm\Service\Synchronizer');
//
//        $config = $synchronizer->load($path);
//
//		$user1 = new Entity\User();
//		$user1->setName('user1');
//		$config->addUser($user1);
//
//		$user2 = new Entity\User();
//		$user2->setName('user2');
//		$config->addUser($user2);
//
//		$user3 = new Entity\User();
//		$user3->setName('user3');
//		$config->addUser($user3);
//
//		$user4 = new Entity\User();
//		$user4->setName('user4');
//		$config->addUser($user4);
//
//		$group1 = new Entity\Group();
//		$group1->setName('group1');
//		$group1->addEntity($user1);
//		$group1->addEntity($user2);
//		$config->addGroup($group1);
//
//		$repository = new Entity\Repository();
//		$repository->setName('repo');
//		$repository->setAccess($user1, new Entity\Access(Entity\Access::READ | Entity\Access::WRITE));
//		$repository->setAccess($user2, new Entity\Access(Entity\Access::READ | Entity\Access::WRITE));
//		$repository->setAccess($user3, new Entity\Access(Entity\Access::READ));
//		$repository->setAccess($group1, new Entity\Access(Entity\Access::WRITE));
//		$config->addRepository($repository);
//
//        $synchronizer->save($config, $path);
//    }
}
