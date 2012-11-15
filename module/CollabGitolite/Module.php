<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $path = 'D:\gitolite-admin\conf\gitolite.conf';

        $sm = $e->getApplication()->getServiceManager();

        $gitolite = $sm->get('collabgitolite.service');
        $gitolite->setConfig($path);

        $user1 = new Entity\User();
        $user1->setUsername('walter.tamboer');
        $user1->setEmail('walter.tamboer@live.com');
        $gitolite->addUser($user1);

        $user2 = new Entity\User();
        $user2->setUsername('test1');
        $gitolite->addUser($user2);

        $user3 = new Entity\User();
        $user3->setUsername('test2');
        $gitolite->addUser($user3);

        $group1 = new Entity\Group();
        $group1->setName('Group1');
        $group1->addUser($user1);
        $gitolite->addGroup($group1);

        $group2 = new Entity\Group();
        $group2->setName('Group2');
        $group2->addUser($user1);
        $gitolite->addGroup($group2);

        $repository1 = new Entity\Repository();
        $repository1->setName('repo1');
        $repository1->addUser($user2);
        $repository1->addGroup($group1);
        $gitolite->addRepository($repository1);

        $writer = new Config\Writer();

        echo '<pre>';
        echo $writer->create($gitolite->getConfig());
        exit;
    }
}
