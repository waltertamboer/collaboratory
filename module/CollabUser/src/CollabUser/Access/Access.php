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
use Zend\Permissions\Acl\Acl;

class Access
{
    private $acl;
    private $loaded;
    private $user;

    public function __construct(User $user)
    {
        $this->loaded = false;
        $this->user = $user;
    }

    public function getAcl()
    {
        return $this->acl;
    }

    private function load()
    {
        if (!$this->loaded) {
            $this->loaded = true;
            $this->acl = new Acl();

            // Get the teams for the current user:
            foreach ($this->user->getTeams() as $team) {
                $role = new Role($team->getName(), $team->isRoot());
                $this->acl->addRole($role);

                foreach ($team->getPermissions() as $permission) {
                    if (!$this->acl->hasResource($permission->getName())) {
                        $this->acl->addResource($permission->getName());
                    }
                    $this->acl->allow($role, $permission->getName());
                }
            }
        }
    }

    public function isRoot()
    {
        $this->load();

//        foreach ($this->acl as $role) {
//            if ($role->isRoot()) {
//                return true;
//            }
//        }

        foreach ($this->acl->getRoles() as $roleName) {
            $role = $this->acl->getRole($roleName);
            if ($role->isRoot()) {
                return true;
            }
        }
        return false;
    }

    public function isGranted($permission, $assert = null)
    {
        $this->load();

        if ($this->isRoot()) {
            return true;
        }

        // When the user is part of a root team, access is granted:
        //foreach ($this->acl as $role) {
        foreach ($this->acl->getRoles() as $roleName) {
            $role = $this->acl->getRole($roleName);
            //if ($role->isRoot() || $this->acl->isGranted($role, $permission, $assert)) {
            if ($role->isRoot() || $this->acl->isAllowed($role, $permission)) {
                return true;
            }
        }
        return false;
    }
}
