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
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManagerAwareInterface;

class SettingsChecker implements EventManagerAwareInterface
{
    private $eventManager;

	private function checkPHPVersion()
	{
		$name = 'PHP Version';

		return new SystemSetting($name, true, 'Your PHP version is ' . phpversion());
	}

	private function checkDataPath()
	{
		$name = 'Data Directory';

		$dataPath = implode(DIRECTORY_SEPARATOR, array(
			realpath('.'),
			'data',
		));

		if (is_writable($dataPath)) {
			$result = new SystemSetting($name, true, 'The path "' . $dataPath . '" is writable.');
		} else {
			$result = new SystemSetting($name, false, 'The path "' . $dataPath . '" should be writable.');
		}
		return $result;
	}

	private function checkMySQL()
	{
		$name = 'PDO MySQL';

		if (extension_loaded('pdo_mysql')) {
			$result = new SystemSetting($name, true, 'The MySQL extension is loaded.');
		} else {
			$result = new SystemSetting($name, false, 'The MySQL extension should be loaded.');
		}
		return $result;
	}

	public function getSettings()
	{
		$systemSettings = array();
		$systemSettings[] = $this->checkPHPVersion();
		$systemSettings[] = $this->checkDataPath();
		$systemSettings[] = $this->checkMySQL();
		return $systemSettings;
	}

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}
