<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabBootstrap;

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'map' => array(
                'bootstrap/css/bootstrap.css' => __DIR__ . '/../public/css/bootstrap.css',
                'bootstrap/css/bootstrap.min.css' => __DIR__ . '/../public/css/bootstrap.min.css',
                'bootstrap/css/bootstrap-responsive.css' => __DIR__ . '/../public/css/bootstrap-responsive.css',
                'bootstrap/css/bootstrap-responsive.min.css' => __DIR__ . '/../public/css/bootstrap-responsive.min.css',
                'bootstrap/img/glyphicons-halflings.png' => __DIR__ . '/../public/img/glyphicons-halflings.png',
                'bootstrap/img/glyphicons-halflings-white.png' => __DIR__ . '/../public/img/glyphicons-halflings-white.png',
                'bootstrap/js/bootstrap.js' => __DIR__ . '/../public/js/bootstrap.js',
                'bootstrap/js/bootstrap.min.js' => __DIR__ . '/../public/js/bootstrap.min.js',
            ),
        ),
    ),
);
