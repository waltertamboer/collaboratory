<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall\Entity;

class SystemSetting
{
	private $name;
	private $valid;
	private $message;

	public function __construct($name, $valid, $message)
	{
		$this->name = $name;
		$this->valid = $valid;
		$this->message = $message;
	}

	public function getName()
	{
		return $this->name;
	}

	public function isValid()
	{
		return $this->valid;
	}

	public function getMessage()
	{
		return $this->message;
	}
}
