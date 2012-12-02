<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssue;

use CollabIssue\Entity\BugPriority;
use CollabIssue\Entity\BugStatus;
use CollabIssue\Service\IssueService;

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
                'CollabIssue\Service\IssueService' => function ($sl) {
                    $mapper = $sl->get('CollabIssue\Mapper\MapperInterface');

                    return new IssueService($mapper);
                },
            )
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();

        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('issue_create');
            $installer->addPermission('issue_update_all');
            $installer->addPermission('issue_update_own');
            $installer->addPermission('issue_delete');
        });
        $sharedManager->attach('CollabInstall', 'initializeEntities', array($this, 'onCreateBugStatusList'));
        $sharedManager->attach('CollabInstall', 'initializeEntities', array($this, 'onCreateBugPriorityList'));
    }

    public function onCreateBugPriorityList($e)
    {
        $installer = $e->getTarget();

        $entity = new BugPriority();
        $entity->setName('bug_priority_low');
        $entity->setLevel(10);
        $installer->addEntity($entity);

        $entity = new BugPriority();
        $entity->setName('bug_priority_medium');
        $entity->setLevel(20);
        $installer->addEntity($entity);

        $entity = new BugPriority();
        $entity->setName('bug_priority_high');
        $entity->setLevel(30);
        $installer->addEntity($entity);
    }

    public function onCreateBugStatusList($e)
    {
        $installer = $e->getTarget();

        $entity = new BugStatus();
        $entity->setName('bug_status_new');
        $entity->setLevel(10);
        $installer->addEntity($entity);

        $entity = new BugStatus();
        $entity->setName('bug_status_feedback');
        $entity->setLevel(20);
        $installer->addEntity($entity);

        $entity = new BugStatus();
        $entity->setName('bug_status_confirmed');
        $entity->setLevel(30);
        $installer->addEntity($entity);

        $entity = new BugStatus();
        $entity->setName('bug_status_assigned');
        $entity->setLevel(40);
        $installer->addEntity($entity);

        $entity = new BugStatus();
        $entity->setName('bug_status_resolved');
        $entity->setLevel(50);
        $installer->addEntity($entity);

        $entity = new BugStatus();
        $entity->setName('bug_status_closed');
        $entity->setLevel(60);
        $installer->addEntity($entity);
    }
}
