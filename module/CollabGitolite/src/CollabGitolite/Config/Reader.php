<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Config;

class Reader
{
    public function read($path, Config $config)
    {
        $lines = file($path);
        $lines = array_filter($lines);

        for ($i = 0; $i < count($lines); ++$i) {
            $line = trim($lines[$i]);

            if ($line) {
                if (preg_match('/repo\s+(.+)/i', $line, $matches)) {
                    //var_dump($matches);
                } else {
                    //var_dump($line);
                }
            }
        }
    }
}
