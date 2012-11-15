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
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'AssetManager',
        'CollabApplication',
        'CollabApplicationDoctrineORM',
        'CollabBootstrap',
        'CollabCalendar',
        'CollabCalendarDoctrineORM',
        'CollabGitolite',
        'CollabIssue',
        'CollabIssueDoctrineORM',
        'CollabProject',
        'CollabProjectDoctrineORM',
        'CollabSnippet',
        'CollabSnippetDoctrineORM',
        'CollabTeam',
        'CollabTeamDoctrineORM',
        'CollabTodo',
        'CollabTodoDoctrineORM',
        'CollabUser',
        'CollabUserDoctrineORM',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local,production,development}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
