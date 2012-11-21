<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabInstall\Service;

use CollabInstall\Entity\SystemSetting;

class SystemPathChecker
{
	private function checkPHPVersion()
	{
		$name = 'PHP Version';

		return new SystemSetting($name, true, 'Your PHP version is ' . phpversion());
	}

	private function checkDoctrineORMPath()
	{
		$name = 'Doctrine ORM Cache Path';

		$doctrineOrmPath = implode(DIRECTORY_SEPARATOR, array(
			realpath('.'),
			'data',
			'DoctrineORMModule',
			'Proxy',
		));

		if (is_writable($doctrineOrmPath)) {
			$result = new SystemSetting($name, true, 'The path "' . $doctrineOrmPath . '" is writable.');
		} else {
			$result = new SystemSetting($name, false, 'The path "' . $doctrineOrmPath . '" should be writable.');
		}
		return $result;
	}

	private function checkProjectsPath()
	{
		$name = 'Projects Path';

		$doctrineOrmPath = implode(DIRECTORY_SEPARATOR, array(
			realpath('.'),
			'data',
			'projects',
		));

		if (is_writable($doctrineOrmPath)) {
			$result = new SystemSetting($name, true, 'The path "' . $doctrineOrmPath . '" is writable.');
		} else {
			$result = new SystemSetting($name, false, 'The path "' . $doctrineOrmPath . '" should be writable.');
		}
		return $result;
	}

	public function getSettings()
	{
		$systemSettings = array();
		$systemSettings[] = $this->checkPHPVersion();
		$systemSettings[] = $this->checkDoctrineORMPath();
		$systemSettings[] = $this->checkProjectsPath();
		return $systemSettings;
	}
}
