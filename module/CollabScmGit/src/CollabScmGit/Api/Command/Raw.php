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

class Raw extends AbstractCommand
{
    private $command;
    private $path;
    private $pathBackup;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getArguments()
    {
        $args = array();

        return $args;
    }

    protected function onExecutePre()
    {
        $this->pathBackup = getcwd();
        chdir($this->path);
    }

    protected function onExecutePost()
    {
        chdir($this->pathBackup);
    }

    public function parse($stdout, $stderr)
    {
        return $stdout;
    }
}
