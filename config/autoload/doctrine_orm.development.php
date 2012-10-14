<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

return array(
    'doctrine' => array(
        'orm_autoload_annotations' => true,
        'connection' => array(
            'orm_default' => array(
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'collaboratory',
                    'password' => 'collaboratory',
                    'dbname' => 'collaboratory',
                )
            ),
        ),
    ),
);
