<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabGitolite\Process;

class Process
{
    private $cwd;
    private $command;
    private $exitCode;
    private $outputStream;
    private $errorStream;

    public function __construct($command)
    {
        $this->cwd = __DIR__;
        $this->command = $command;
    }

    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function getErrorStream()
    {
        return $this->errorStream;
    }

    public function getOutputStream()
    {
        return $this->outputStream;
    }

    public function run()
    {
        $specs = array(
            '0' => array('pipe', 'r'),
            '1' => array('pipe', 'w'),
            '2' => array('pipe', 'w'),
        );

        $pipes = array();
        $handle = proc_open($this->command, $specs, $pipes, $this->cwd);
        if (!$handle) {
            throw new ProcessException('Failed to open the process.');
        }

        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);

        do {
            $status = proc_get_status($handle);
        } while ($status['running']);

        $this->outputStream = stream_get_contents($pipes[1]);
        $this->errorStream = stream_get_contents($pipes[2]);

        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $this->exitCode = proc_close($handle);
        return $this->exitCode != -1;
    }
}
