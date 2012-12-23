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

class GitClone extends AbstractCommand
{
    private $path;
    private $repository;

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    public function getCommand()
    {
        return 'clone';
    }

    public function getArguments()
    {
        $args = array();
        $args[] = $this->repository;
        if ($this->path) {
            $args[] = '"' . $this->path . '"';
        }

        return $args;
    }

    public function parse($stdout, $stderr)
    {
    }
}
