<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Service;

use CollabGitolite\Config\Config;
use CollabGitolite\Entity\User;
use CollabGitolite\Entity\Group;
use CollabGitolite\Entity\Repository;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class GitoliteService implements ServiceManagerAwareInterface
{
    private $serviceManager;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    private function execute($command)
    {
        set_time_limit(0);
        ignore_user_abort(true);

        echo '<pre>';

        $specs = array(
            '0' => array('pipe', 'r'),
            '1' => array('pipe', 'w'),
            '2' => array('pipe', 'w'),
        );

        $cwd = __DIR__;

        $handle = proc_open($command, $specs, $pipes, $cwd);
        if ($handle) {
            var_dump($handle);
            stream_set_blocking($pipes[1], 0);
            stream_set_blocking($pipes[2], 0);

            do {
                $status = proc_get_status($handle);
            } while ($status['running']);

            if (true) {
                echo stream_get_contents($pipes[1]);
                echo stream_get_contents($pipes[2]);
            }

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($handle);
            echo '<p>Exit code: ' . $exitCode . '</p>';
        } else {
            echo 'No Handle!';
        }
    }

    public function pull()
    {
        $config = $this->serviceManager->get('Config');

        $localDir = $config['collaboratory']['gitolite']['tmp_path'];
        $remoteDir = $config['collaboratory']['gitolite']['repository'];

        if (is_dir($localDir)) {
            $this->execute('git pull ' . $localDir);
        } else {
            $this->execute('git clone ' . $remoteDir . ' ' . $localDir);
        }
    }

    private $config;

    public function getConfig()
    {
        if ($this->config === null) {
            // @todo get it from the service manager?
        }
        return $this->config;
    }

    public function setConfig($config)
    {
        if ($config instanceof Config) {
            $this->config = $config;
        } else {
            $this->config = new Config($config);
        }
        return $this;
    }

    public function addUser(User $user)
    {
        $this->config->addUser($user);
        return $this;
    }

    public function getUsers()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getUsers();
    }

    public function addGroup(Group $group)
    {
        $this->config->addGroup($group);
        return $this;
    }

    public function getGroups()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getGroups();
    }

    public function addRepository(Repository $repository)
    {
        $this->config->addRepository($repository);
        return $this;
    }

    public function getRepositories()
    {
        if (!$this->config) {
            throw new \Exception('No configuration has been set.');
        }
        return $this->config->getRepositories();
    }
}
