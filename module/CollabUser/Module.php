<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser;

use CollabUser\Authentication\AuthenticationService;
use CollabUser\Controller\Plugin\UserAuthentication;
use CollabUser\View\Helper\UserAvatar;
use CollabUser\View\Helper\UserDisplayName;
use CollabUser\View\Helper\UserIdentity;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'userAuthentication' => function($sm) {
                    $instance = new UserAuthentication();
                    $instance->setServiceManager($sm);
                    return $instance;
                },
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'collabuser.adapter' => 'CollabUser\Authentication\Adapter\DbAdapter',
                'collabuser.storage' => 'Zend\Authentication\Storage\Session',
            ),
            'factories' => array(
                'collabuser.authservice' => function ($sm) {
                    $service = new AuthenticationService();
                    $service->setAdapter($sm->get('collabuser.adapter'));
                    return $service;
                },
                'collabuser.userservice' => 'CollabUser\Service\UserServiceFactory',
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'userAvatar' => function ($sm) {
                    $locator = $sm->getServiceLocator();

                    $viewHelper = new UserAvatar();
                    $viewHelper->setAuthService($locator->get('collabuser.authservice'));
                    return $viewHelper;
                },
                'userDisplayName' => function ($sm) {
                    $locator = $sm->getServiceLocator();

                    $viewHelper = new UserDisplayName();
                    $viewHelper->setAuthService($locator->get('collabuser.authservice'));
                    return $viewHelper;
                },
                'userIdentity' => function ($sm) {
                    $locator = $sm->getServiceLocator();

                    $viewHelper = new UserIdentity();
                    $viewHelper->setAuthService($locator->get('collabuser.authservice'));
                    return $viewHelper;
                },
            ),
        );
    }

    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $routeMatch = $e->getRouteMatch();
            $controller = $routeMatch->getParam('controller');
            $action = $routeMatch->getParam('action');

            if ($controller == 'CollabUser\Controller\UserController' && $action == 'login' || $action == 'logout') {
                $e->getTarget()->layout('layout/empty');
            }
        }, 100);
    }
}
