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

        $arguments = array();
        $arguments[] = $this->getExecutable();
        if ($this->getLocalRepository()) {
            $arguments[] = '--git-dir=' . realpath($this->getLocalRepository());
        }
        $arguments[] = $this->getCommand();

        $shellCommand = array_merge($arguments, $this->getArguments());
		$command = implode(' ', $shellCommand);

        $output = shell_exec($command);
        return $this->parse($output);
    }
}
