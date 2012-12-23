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

    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'CollabScm\Controller\RepositoryController' => 'CollabScm\Controller\RepositoryController',
            ),
        );
    }

    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'ScmPath' => 'CollabScm\Controller\Plugin\ScmPath',
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CollabScm\Service\Repository' => 'CollabScm\Service\RepositoryServiceFactory',
                'CollabScm\Service\RepositoryTeam' => 'CollabScm\Service\RepositoryTeamServiceFactory',
                'CollabScm\Validator\RepositoryName' => function ($sm) {
                    $entityManager = $sm->get('doctrine.entitymanager.orm_default');
                    return new \CollabApplicationDoctrineORM\Validator\UniqueEntity($entityManager, 'CollabScm\Entity\Repository', 'name', 'getName');
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'collabRepoAddress' => 'CollabScm\View\Helper\Address',
            ),
        );
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();

        $eventManager = $application->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('CollabInstall', 'initializePermissions', function($e) {
            $installer = $e->getTarget();
            $installer->addPermission('repository_create');
            $installer->addPermission('repository_update');
            $installer->addPermission('repository_delete');
        });
    }
}
