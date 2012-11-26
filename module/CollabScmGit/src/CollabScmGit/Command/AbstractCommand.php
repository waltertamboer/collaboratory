<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmGit\Command;

abstract class AbstractCommand
{
    private $repository;

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
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
        $arguments = array();
        $arguments[] = $this->getExecutable();
        if ($this->getRepository()) {
            $arguments[] = '--git-dir=' . realpath($this->getRepository());
        }
        $arguments[] = $this->getCommand();

        $shellCommand = array_merge($arguments, $this->getArguments());

		$command = implode(' ', $shellCommand);
		var_dump($command);
        $output = shell_exec($command);
        return $this->parse($output);
    }
}
