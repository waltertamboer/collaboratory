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

use CollabUser\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class UserAvatar extends AbstractHelper
{
    private $authService;
	private $user;
	private $gravatar;

    public function __invoke(User $user = null)
    {
        if ($user) {
			$this->user = $user;
		} else {
            $this->user = $this->authService->getIdentity();
        }
		
		$view = $this->getView();
		$this->gravatar = $view->gravatar($this->user->getIdentity())->setImgSize(24);
		
		return $this;
    }
	
	
	public function __toString()
	{
        return (string)$this->gravatar;
	}
	
	public function getUrl()
	{
		$imgTag = $this->gravatar->getImgTag();
		
		$url = null;
		if (preg_match('/src="(.+?)"/i', $imgTag, $matches)) {
			$url = $matches[1];
		}
		return $url;
	}

    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }
}
