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

class LsTree extends AbstractCommand
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
        return 'ls-tree';
    }

    public function getArguments()
    {
        $args = array();
        $args[] = '--full-name';
        $args[] = '-l';
		$args[] = '-t';
        $args[] = $this->treeIsh;
        $args[] = $this->path;

        return $args;
    }

    public function parse($data)
    {
        $result = array();
        foreach (explode("\n", $data) as $line) {
            if (preg_match('/^([0-9]+) (.+) ([0-9a-fA-F]{40})(\s+[0-9]+|\s+-)?\s+(.+)$/i', $line, $matches)) {
				switch($matches[2]) {
					case 'tree':
						$data = array();
						$data['type'] = 'tree';
						$data['hash'] = $matches[3];
						$data['mode'] = $matches[1];
						$data['path'] = $matches[5];

						$result[] = $data;
						break;
					case 'blob':
						$data = array();
						$data['type'] = 'blob';
						$data['hash'] = $matches[3];
						$data['mode'] = $matches[1];
                        $data['size'] = trim($matches[4]);

						$path = $matches[5];
						if (!empty($treePath))
							$path = $treePath . '/' . $path;
						$data['path'] = $path;

						$result[] = $data;
						break;
				}
            }
        }
        return $result;
    }
}
