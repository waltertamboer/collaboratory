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

class Push extends AbstractCommand
{
    private $branch;
    private $path;
    private $pathBackup;

    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getCommand()
    {
        return 'push';
    }

    public function getArguments()
    {
        $args = array();
        $args[] = 'origin';
        if ($this->branch) {
            $args[] = $this->branch;
        }
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
    }
}
