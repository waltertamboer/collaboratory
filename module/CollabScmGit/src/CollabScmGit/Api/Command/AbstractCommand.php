<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmGit\Api\Command;

abstract class AbstractCommand
{
    private $localRepository;

    public function getLocalRepository()
    {
        return $this->localRepository;
    }

    public function setLocalRepository($repository)
    {
        $this->localRepository = $repository;
    }

    private function getExecutable()
    {
        return 'git';
    }

    public abstract function getArguments();

    public abstract function getCommand();

    public abstract function parse($data);

    public function execute()
    {
        set_time_limit(0);
        $result = null;

        $specs = array(
            '0' => array('pipe', 'r'),
            '1' => array('pipe', 'w'),
            '2' => array('pipe', 'w'),
        );

        $arguments = array();
        $arguments[] = $this->getExecutable();
        if ($this->getLocalRepository()) {
            $arguments[] = '--git-dir=' . realpath($this->getLocalRepository());
        }
        $arguments[] = $this->getCommand();

        $shellCommand = array_merge($arguments, $this->getArguments());
        $cmd = implode(' ', $shellCommand);

        $handle = proc_open($cmd, $specs, $pipes, getcwd());
        if ($handle) {
            stream_set_blocking($pipes[1], 0);
            stream_set_blocking($pipes[2], 0);

            do {
                $status = proc_get_status($handle);
            } while ($status['running']);

            $data = stream_get_contents($pipes[1]);
            $result = $this->parse($data);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($handle);
        }

        return $result;
    }
}
