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

use Zend\Permissions\Acl\Role\GenericRole;

class Role extends GenericRole
{
    private $root;

    public function __construct($name, $root)
    {
        parent::__construct($name);
        $this->root = $root;
    }

    public function isRoot()
    {
        return $this->root;
    }
}
