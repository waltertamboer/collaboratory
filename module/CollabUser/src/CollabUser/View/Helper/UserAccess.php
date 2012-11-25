<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\View\Helper;

use CollabUser\Access\Access;
use Zend\View\Helper\AbstractHelper;

class UserAccess extends AbstractHelper
{
    private $access;

    public function __invoke($permission, $assert = null)
    {
        return $this->access->isGranted($permission, $assert);
    }

    public function setAccess(Access $access)
    {
        $this->access = $access;
    }
}
