<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser;

use CollabUser\Access\Access;
use CollabUser\Authentication\AuthenticationService;
use CollabUser\Controller\Plugin\UserAuthentication;
use CollabUser\Service\PermissionService;
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
                'CollabSsh\Service\KeysService' => 'CollabSsh\Service\KeysServiceFactory',
                'CollabUser\Access' => function ($sm) {
                    $authService = $sm->get('collabuser.authservice');
                    $currentUser = $authService->getIdentity();

                    return new Access($currentUser);
                },
                'CollabUser\Service\Permission' => function ($sm) {
                    $mapper = $sm->get('CollabUser\Mapper\Permission');

                    return new PermissionService($mapper);
                },
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
        $application = $e->getApplication();

        $eventManager = $application->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $routeMatch = $e->getRouteMatch();
            $controller = $routeMatch->getParam('controller');
            $action = $routeMatch->getParam('action');

            $path = 'config/autoload/doctrine_orm.global.php';
            if (is_file($path)) {
				$publicPages = array();
				$publicPages['CollabUser\Controller\UserController'] = array('login', 'logout');
				$publicPages['CollabInstall\Controller\InstallController'] = array('index', 'database', 'account', 'finish');

				if (array_key_exists($controller, $publicPages) && in_array($action, $publicPages[$controller])) {
					$e->getTarget()->layout('layout/empty');
				} else {
                    $sm = $e->getTarget()->getServiceLocator();
                    $authService = $sm->get('collabuser.authservice');

                    if (!$authService->getIdentity()) {
                        $controller = $e->getTarget();
                        return $controller->redirect()->toRoute('user/login');
                    }
                }
			} else {
				$e->getTarget()->layout('layout/empty');
			}
        }, 100);
    }
}
