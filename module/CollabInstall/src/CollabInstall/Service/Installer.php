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

use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManager;

class Installer
{
	private $entityManager;

	public function __construct(ServiceManager $serviceManager)
	{
		$this->entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
	}

	private function createConfigFile($database)
	{
		$configFile = realpath('./config/autoload') . '/doctrine_orm.global.php';

		$content = file_get_contents($configFile . '.dist');
		$content = str_replace('collaboratory-host', $database['host'], $content);
		$content = str_replace('collaboratory-port', $database['port'], $content);
		$content = str_replace('collaboratory-username', $database['username'], $content);
		$content = str_replace('collaboratory-password', $database['password'], $content);
		$content = str_replace('collaboratory-database', $database['dbname'], $content);

		file_put_contents($configFile, $content);
	}

	private function createDatabaseStructure($metaData)
	{
		$tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
		$tool->dropDatabase();
		$tool->createSchema($metaData);
	}

	private function createDatabaseProxies($metaData)
	{
		$destPath = getcwd() . '/data/DoctrineORMModule/Proxy';
		$this->entityManager->getProxyFactory()->generateProxyClasses($metaData, $destPath);
	}

	private function createAccount($account)
	{
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $credential = $bcrypt->create($account['credential']);

		$adminUser = new \CollabUser\Entity\User();
		$adminUser->setIdentity($account['identity']);
		$adminUser->setCredential($credential);
		$adminUser->setDisplayName($account['displayName']);

		$this->entityManager->persist($adminUser);
		$this->entityManager->flush();
	}

	public function run($database, $account)
	{
		$metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();

		$this->createConfigFile($database);
		$this->createDatabaseStructure($metaData);
		$this->createDatabaseProxies($metaData);
		$this->createAccount($account);
	}
}
