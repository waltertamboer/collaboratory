<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Service;

use CollabScm\Config\Config;
use CollabScm\Entity\User;
use CollabScm\Entity\Group;
use CollabScm\Entity\Repository;

class Synchronizer
{
    public function load($path)
    {
        $config = new Config();

        return $config;
    }

    public function save(Config $config, $path)
    {
        $data = array();

        $data['users'] = array();
        foreach ($config->getUsers() as $entity) {
            $data['users'][] = array(
                'username' => $entity->getUsername(),
                'email' => $entity->getEmail(),
            );
        }

        $data['repositories'] = array();
        foreach ($config->getRepositories() as $repository) {
            $repositoryName = $repository->getName();

            $data['repositories'][$repositoryName] = array();

            $data['repositories'][$repositoryName]['options'] = array();
            foreach ($repository->getOptions() as $name => $value) {
                $data['repositories'][$repositoryName]['options'][$name] = $value;
            }

            $data['repositories'][$repositoryName]['users'] = array();
            foreach ($repository->getUsers() as $username => $access) {
                $data['repositories'][$repositoryName]['users'][$username] = 'R';
            }
        }

        $json = json_encode($data);
        echo '<pre>';
        print_r(json_decode($json));
        echo '</pre>';
        file_put_contents($path, $json);
    }
}
