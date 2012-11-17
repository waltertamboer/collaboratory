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

class Writer
{
    public function create(Config $config)
    {
        $content = '';

        $groups = $config->getGroups();
        if ($groups) {
            foreach ($groups as $group) {
                $content .= '@' . $group->getName() . ' =';
                foreach ($group->getUsers() as $user) {
                    $content .= ' ' . $user->getUsername();
                }
                $content .= PHP_EOL;
            }
            $content .= PHP_EOL;
        }

        foreach ($config->getRepositories() as $repository) {
            $content .= 'repo ' . $repository->getName() . '' . PHP_EOL;
            foreach ($repository->getGroups() as $name => $access) {
                $content .= '    ' . $access->getPermission();
                if ($access->getRefex()) {
                    $content .= ' ' . $access->getRefex();
                }
                $content .= ' = @' . $name . PHP_EOL;
            }
            foreach ($repository->getUsers() as $name => $access) {
                $content .= '    ' . $access->getPermission();
                if ($access->getRefex()) {
                    $content .= ' ' . $access->getRefex();
                }
                $content .= ' = ' . $name . PHP_EOL;
            }
            foreach ($repository->getOptions() as $name => $value) {
                $content .= '    option ' . $name . ' = ' . $value . PHP_EOL;
            }
            $content .= PHP_EOL;
        }

        return $content;
    }

    public function save($path, Config $config)
    {
//        $content = $this->create($config);
//
//        file_put_contents($path);

        return $this;
    }

}
