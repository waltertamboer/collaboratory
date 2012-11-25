<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeam\Entity;

use CollabUser\Entity\User;
use DateTime;

class Team
{
    private $id;
    private $root;
    private $name;
    private $previousName;
    private $description;
    private $createdBy;
    private $createdOn;
    private $members;
    private $projects;
    private $permissions;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function isRoot()
    {
        return $this->root;
    }

    public function setRoot($root)
    {
        $this->root = $root ? true : false;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPreviousName()
    {
        return $this->previousName;
    }

    public function setName($name)
    {
        $this->previousName = $this->name;
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function addMember(User $member)
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }
        return $this;
    }

    public function clearMembers()
    {
        foreach ($this->members as $member) {
            $member->removeTeam($this);
        }
        $this->members->clear();
        return $this;
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function removeMember(User $user)
    {
        if ($this->members->contains($user)) {
            $this->members->removeElement($user);
            $user->removeTeam($this);
        }
    }

    public function setMembers($members)
    {
        $this->clearMembers();
        foreach ($members as $member) {
            if ($member) {
                $this->addMember($member);
                $member->addTeam($this);
            }
        }
        return $this;
    }

    public function getProjects()
    {
        return $this->projects;
    }

    public function setProjects($projects)
    {
        $this->projects->clear();
        foreach ($projects as $project) {
            if ($project) {
                $project->addTeam($this);
                $this->projects->add($project);
            }
        }
        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }
}
