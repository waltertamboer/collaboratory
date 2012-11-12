<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUser\View\Helper;

use CollabUser\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class UserDisplayName extends AbstractHelper
{
    private $authService;

    public function __invoke(User $user = null)
    {
        $result = '';

        if ($user === null) {
            $user = $this->authService->getIdentity();
        }

        if ($user) {
            $result = $user->getDisplayName();
            if (!$result) {
                $result = $user->getIdentity();
                $result = substr($result, 0, strpos($result, '@'));
            }
        }

        return $result;
    }

    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }
}
