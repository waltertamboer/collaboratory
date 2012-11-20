<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall;

use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getTarget()->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $routeName = $e->getRouteMatch()->getMatchedRouteName();

            $path = 'config/autoload/doctrine_orm.production.php';
            if (!is_file($path)) {
                if ($routeName != 'install') {
                    return $e->getTarget()->redirect()->toRoute('install');
                }
            } else if ($routeName == 'install') {
                return $e->getTarget()->redirect()->toRoute('dashboard');
            }
        }, 101);
    }
}
