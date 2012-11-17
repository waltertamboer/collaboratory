<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite;

return array(
    'collaboratory' => array(
        'gitolite' => array(
            'tmp_path' => '/tmp/gitolite-admin',
            'repository' => 'git@localhost:gitolite-admin.git',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'collabgitolite.service' => 'CollabGitolite\Service\GitoliteService'
        ),
    ),
);
