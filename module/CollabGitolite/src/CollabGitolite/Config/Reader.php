<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Config;

use CollabGitolite\Entity\Access;
use CollabGitolite\Entity\Group;
use CollabGitolite\Entity\Repository;
use CollabGitolite\Entity\User;

class Reader
{
    const PERMISSIONS_REGEX = '/-|R|RW+?C?D?M?/i';

    public function read($path, Config $config)
    {
        $content = file_get_contents($path);
        $tokens = preg_split('/ \n/ise', $content);

        var_dump($tokens);

        while (count($tokens)) {
            $token = array_shift($tokens);

            echo ord($token[0]) . '<br />';
            continue;

            var_dump('FIRST TOKEN -> ' . $token);

            if ($token == 'repo') {
                $this->parseRepository($config, $tokens);
            } else if ($token[0] == '@') {
                $this->parseGroup($config, $tokens);
            }
        }

        echo '<pre>';print_r($config);
        exit;
    }

    private function parseRepository(Config $config, $tokens)
    {
        $name = array_shift($tokens);
        $repository = $this->createRepository($config, $name);

        var_dump('REPO NAME -> ' . $name);

        while (count($tokens)) {
            $token = $tokens[0];

            var_dump('EXPECT PERMISSION -> ' . $token);

            if (!$this->isPermission($token)) {
                var_dump('NO PERMISSION FOUND -> ' . $token);
                break;
            }

            $permission = array_shift($tokens);
            $access = new Access($permission);

            var_dump('PERMISSION -> ' . $permission);

            // The next token might be a refex:
            $token = array_shift($tokens);
            if ($token != '=') {
                var_dump('REFEX -> ' . $token);
                $access->setRefex($token);
                $token = array_shift($tokens); // This is the equal sign
            }

            var_dump('EQUAL SIGN -> ' . $token);

            while (count($tokens)) {
                if ($tokens[0] == 'repo' || $this->isPermission($tokens[0])) {
                    var_dump('BREAKING -> ' . $tokens[0]);
                    break;
                }

                $token = array_shift($tokens);
                var_dump('USER OR GROUP -> ' . $token);

                if ($token[0] == '@') {
                    $entity = $this->createGroup($config, substr($token, 1));
                    $repository->addGroup($entity, $access);
                } else {
                    $entity = $this->createUser($config, $token);
                    $repository->addUser($entity, $access);
                }
            }
        }
    }

    private function parseGroup(Config $config, $tokens)
    {

    }

    private function createRepository(Config $config, $name)
    {
        $repository = new Repository();
        $repository->setName($name);

        $config->addRepository($repository);
        return $repository;
    }

    private function createUser(Config $config, $name)
    {
        $entity = new User();
        $entity->setUsername($name);

        $config->addUser($entity);
        return $entity;
    }

    private function createGroup(Config $config, $name)
    {
        $entity = new Group();
        $entity->setName($name);

        $config->addGroup($entity);
        return $entity;
    }

    private function isPermission($token)
    {
        return preg_match(self::PERMISSIONS_REGEX, $token);
    }
}
