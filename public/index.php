<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

// Change the working directory to the application's root:
chdir(dirname(__DIR__));

// Setup autoloading:
require 'autoloading.php';

// Run the application:
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
