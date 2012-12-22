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

class RevParse extends AbstractCommand
{
    private $path;
    private $treeIsh;

	public function __construct()
	{
		$this->treeIsh = 'HEAD';
	}

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setTreeIsh($treeIsh)
    {
        $this->treeIsh = $treeIsh;
        return $this;
    }

    public function getCommand()
    {
        return 'rev-parse';
    }

    public function getArguments()
    {
        $args = array();
        $args[] = '--verify';
        $args[] = $this->treeIsh;
        $args[] = $this->path;

        return $args;
    }

    public function parse($data)
    {
        var_dump($data);
        exit;
    }
}
