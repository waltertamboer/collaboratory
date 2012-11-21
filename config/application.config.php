<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'CollabApplication',
        'CollabApplicationDoctrineORM',
        'CollabCalendar',
        'CollabCalendarDoctrineORM',
        'CollabInstall',
        'CollabIssue',
        'CollabIssueDoctrineORM',
        'CollabProject',
        'CollabProjectDoctrineORM',
        'CollabScm',
        'CollabSnippet',
        'CollabSnippetDoctrineORM',
        'CollabTeam',
        'CollabTeamDoctrineORM',
        'CollabUser',
        'CollabUserDoctrineORM',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
