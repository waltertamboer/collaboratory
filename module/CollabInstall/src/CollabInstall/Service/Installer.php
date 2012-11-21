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
	public function createConfigFile($database)
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

	public function createDatabase($entityManager)
	{
        $classes = $entityManager->getMetaDataFactory()->getAllMetadata();

		$tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
		$tool->dropDatabase();
		$tool->createSchema($classes);

		$destPath = getcwd() . '/data/DoctrineORMModule/Proxy';
		$entityManager->getProxyFactory()->generateProxyClasses($classes, $destPath);
	}

	public function createAccount($entityManager, $account)
	{
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $credential = $bcrypt->create($account['credential']);

		$adminUser = new \CollabUser\Entity\User();
		$adminUser->setIdentity($account['identity']);
		$adminUser->setCredential($credential);
		$adminUser->setDisplayName($account['displayName']);

		$entityManager->persist($adminUser);
		$entityManager->flush();
	}

    public function createConnection($data)
    {
        $config = new \Doctrine\DBAL\Configuration();
        $params = array(
            'driver' => 'pdo_mysql',
            'host' => $data['host'],
            'port' => $data['port'],
            'user' => $data['username'],
            'password' => $data['password'],
            'dbname' => $data['dbname'],
        );

        $connection = \Doctrine\DBAL\DriverManager::getConnection($params, $config);
        $connection->connect();

        return $connection;
    }
}
