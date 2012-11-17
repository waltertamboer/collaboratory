<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\Authentication;

use Zend\Authentication\AuthenticationService as BaseAuthenticationService;

class AuthenticationService extends BaseAuthenticationService
{
    protected $resolvedIdentity;

    public function getIdentity()
    {
        if (!$this->resolvedIdentity) {
            $id = parent::getIdentity();
            if ($id) {
                $mapper = $this->getAdapter()->getMapper();

                $this->resolvedIdentity = $mapper->findById($id);
            }
        }
        return $this->resolvedIdentity;
    }
}
