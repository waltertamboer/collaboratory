<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Entity;

use CollabTeam\Entity\Team;

class User
{
    private $id;
    private $identity;
    private $credential;
    private $displayName;
    private $previousDisplayName;
    private $snippets;
    private $teams;
    private $sshKeys;

    public function __construct()
    {
        $this->snippets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sshKeys = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    public function getCredential()
    {
        return $this->credential;
    }

    public function setCredential($credential)
    {
        $this->credential = $credential;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getPreviousDisplayName()
    {
        return $this->previousDisplayName;
    }

    public function setDisplayName($displayName)
    {
        $this->previousDisplayName = $this->displayName;
        $this->displayName = $displayName;
        return $this;
    }

    public function getSnippets()
    {
        return $this->snippets;
    }

    public function setSnippets($snippets)
    {
        $this->snippets->clear();
        foreach ($snippets as $snippet) {
            $this->snippets->add($snippet);
        }
        return $this;
    }

    public function addTeam(Team $team)
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }
        return $this;
    }

    public function clearTeams()
    {
        foreach ($this->teams as $team) {
            $team->removeMember($this);
        }
        $this->teams->clear();
        return $this;
    }

    public function getTeams()
    {
        return $this->teams;
    }

    public function removeTeam(Team $team)
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $team->removeMember($this);
        }
    }

    public function setTeams($teams)
    {
        $this->clearTeams();
        foreach ($teams as $team) {
            if ($team instanceof Team) {
                $this->addTeam($team);
                $team->addMember($this);
            }
        }
        return $this;
    }

    public function getSshKeys()
    {
        return $this->sshKeys;
    }

    public function setSshKeys($sshKeys)
    {
        $this->sshKeys = $sshKeys;
        return $this;
    }
}
