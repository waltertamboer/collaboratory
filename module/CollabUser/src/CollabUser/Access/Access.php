<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Access;

use CollabUser\Entity\User;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

class Access
{
    private $rbac;
    private $loaded;
    private $user;

    public function __construct(User $user)
    {
        $this->loaded = false;
        $this->user = $user;
    }

    public function getRbac()
    {
        return $this->rbac;
    }

    private function load()
    {
        if (!$this->loaded) {
            $this->loaded = true;
            $this->rbac = new Rbac();

            // Get the teams for the current user:
            foreach ($this->user->getTeams() as $team) {
                $role = new Role($team->getName());
                foreach ($team->getPermissions() as $permission) {
                    $role->addPermission($permission->getName());
                }
                $this->rbac->addRole($role);
            }
        }
    }

    public function isGranted($permission, $assert = null)
    {
        $this->load();

        $result = false;
        foreach ($this->rbac as $role) {
            if ($this->rbac->isGranted($role, $permission, $assert)) {
                $result = true;
                break;
            }
        }
        return $result;
    }
}
