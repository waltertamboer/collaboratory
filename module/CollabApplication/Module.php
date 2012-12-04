<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication;

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
                'navigation/main' => 'Zend\Navigation\Service\DefaultNavigationFactory',
                'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
                'CollabApplication\Service\SassFilterFactory' => 'CollabApplication\Service\SassFilterFactory',
                'CollabApplication\Service\ApplicationEvents' => function($sm) {
                    $mapper = $sm->get('CollabApplication\Mapper\ApplicationEvents');
                    return new Service\ApplicationEvents($mapper);
                },
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'formatApplicationEvent' => function ($sm) {
                    return new View\Helper\FormatApplicationEvent();
                },
            ),
        );
    }

    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $applicationEvents = $sm->get('CollabApplication\Service\ApplicationEvents');

        $sm->addInitializer(function($class) use ($applicationEvents) {
                if ($class instanceof Events\ApplicationEventsAwareInterface) {
                    $class->setApplicationEvents($applicationEvents);
                }
            });
    }

}
