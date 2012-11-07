<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace Application\Entity;

class Project
{
    private $id;
    private $name;
    private $description;
    private $teams;
    private $snippets;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
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

    public function getTeams()
    {
        return $this->teams;
    }

    public function setTeams($teams)
    {
        $this->teams = $teams;
        return $this;
    }

    public function getSnippets()
    {
        return $this->snippets;
    }

    public function setSnippets($snippets)
    {
        $this->snippets = $snippets;
        return $this;
    }
}
