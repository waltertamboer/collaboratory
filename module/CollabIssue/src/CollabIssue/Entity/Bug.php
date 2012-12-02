<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssue\Entity;

class Bug extends Issue
{
    private $status;
    private $reproducibility;
    private $priority;

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(BugStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getReproducibility()
    {
        return $this->status;
    }

    public function setReproducibility($reproducibility)
    {
        $this->reproducibility = $reproducibility;
        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority(BugPriority $priority)
    {
        $this->priority = $priority;
        return $this;
    }
}
