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

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class UserIdentity extends AbstractHelper
{
    private $authService;

    public function __invoke()
    {
        return $this->authService->getIdentity();
    }

    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }
}
