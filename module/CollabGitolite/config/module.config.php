<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite;

return array(
    'service_manager' => array(
        'invokables' => array(
            'collabgitolite.service' => 'CollabGitolite\Service\GitoliteService'
        ),
    ),
);
