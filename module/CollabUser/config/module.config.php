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

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/screen.css' => array(
                    __NAMESPACE__ . '/sass/login.scss',
                ),
            ),
            'map' => array(
                __NAMESPACE__ . '/sass/login.scss' => __DIR__ . '/../public/sass/login.scss',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CollabSsh\Controller\KeysController' => 'CollabSsh\Controller\KeysController',
            'CollabUser\Controller\AccountController' => 'CollabUser\Controller\AccountController',
            'CollabUser\Controller\UserController' => 'CollabUser\Controller\UserController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'user/overview' => array(
                'label' => 'Users',
                'route' => 'account/overview',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'account' => include __DIR__ . '/routes.account.php',
            'ssh' => include __DIR__ . '/routes.ssh.php',
            'settings' => include __DIR__ . '/routes.settings.php',
            'user' => include __DIR__ . '/routes.user.php',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
