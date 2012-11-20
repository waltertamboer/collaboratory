<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Entity;

class Access
{
    const PERMISSION_D = '-';
    const PERMISSION_R = 'R';
    const PERMISSION_RW = 'RW';
    const PERMISSION_RWP = 'RW+';
    const PERMISSION_RWC = 'RWC';
    const PERMISSION_RWPC = 'RW+C';
    const PERMISSION_RWD = 'RWD';
    const PERMISSION_RWPD = 'RW+D';
    const PERMISSION_RWCD = 'RWCD';
    const PERMISSION_RWPCD = 'RW+CD';

    /**
     * The permission.
     *
     * @var string
     */
    private $permission;

    /**
     * The optional refex. See http://sitaramc.github.com/gitolite/refex.html
     *
     * @var string
     */
    private $refex;

    public function __construct($permission, $refex = '')
    {
        $this->permission = $permission;
        $this->refex = $refex;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

    public function getRefex()
    {
        return $this->refex;
    }

    public function setRefex($refex)
    {
        $this->refex = $refex;
        return $this;
    }
}
