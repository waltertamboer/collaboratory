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


    public function onBootstrap($e)
    {
        $path = __DIR__ . '/collaboratory.json';

        $sm = $e->getApplication()->getServiceManager();

        $synchronizer = $sm->get('CollabScm\Service\Synchronizer');

        $config = $synchronizer->load($path);

        var_dump($config);

        $user1 = new Entity\User();
        $user1->setUsername('walter.tamboer');
        $user1->setEmail('walter.tamboer@live.com');
        $config->addUser($user1);

        $user2 = new Entity\User();
        $user2->setUsername('test1');
        $config->addUser($user2);

        $user3 = new Entity\User();
        $user3->setUsername('test2');
        $config->addUser($user3);

        $repository1 = new Entity\Repository();
        $repository1->setName('repo1');
        $repository1->addUser($user2, new Entity\Access(Entity\Access::PERMISSION_R));
        $config->addRepository($repository1);

        $repository2 = new Entity\Repository();
        $repository2->setName('repo2');
        $repository2->addUser($user1, new Entity\Access(Entity\Access::PERMISSION_RWPCD, 'dev'));
        $repository2->addUser($user2, new Entity\Access(Entity\Access::PERMISSION_RWD));
        $config->addRepository($repository2);

        $synchronizer->save($config, $path);

        var_dump($config);
        exit;
    }
}
