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

use Doctrine\ORM\EntityManager;
use Zend\Crypt\Password\Bcrypt;
use Zend\EventManager\EventManager;
use CollabUser\Entity\Permission;

class Installer
{
    private $entityManager;
    private $eventManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

	public function createConfigFile($database)
	{
		$dbConfigFile = realpath('./config/autoload') . '/doctrine_orm.global.php';

		$content = file_get_contents($dbConfigFile . '.dist');
		$content = str_replace('{DB_HOST}', $database['host'], $content);
		$content = str_replace('{DB_PORT}', $database['port'], $content);
		$content = str_replace('{DB_USER}', $database['username'], $content);
		$content = str_replace('{DB_PASS}', $database['password'], $content);
		$content = str_replace('{DB_NAME}', $database['dbname'], $content);

		file_put_contents($dbConfigFile, $content);
	}

	public function createDatabase()
	{
        $classes = $this->entityManager->getMetaDataFactory()->getAllMetadata();

		$tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
		$tool->dropDatabase();
		$tool->createSchema($classes);

		$destPath = getcwd() . '/data/DoctrineORMModule/Proxy';
		$this->entityManager->getProxyFactory()->generateProxyClasses($classes, $destPath);
	}

	public function createEntities($account)
	{
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $credential = $bcrypt->create($account['credential']);

        // Create the root user:
		$rootUser = new \CollabUser\Entity\User();
		$rootUser->setIdentity($account['identity']);
		$rootUser->setCredential($credential);
		$rootUser->setDisplayName($account['displayName']);

		$this->entityManager->persist($rootUser);
		$this->entityManager->flush();

        // Create the owners team:
        $ownersTeam = new \CollabTeam\Entity\Team();
        $ownersTeam->setRoot(true);
        $ownersTeam->setName('Owners');
        $ownersTeam->setDescription('The people in this team are maintainers of Collaboratory.');
        $ownersTeam->addMember($rootUser);
        $ownersTeam->setCreatedBy($rootUser);

		$this->entityManager->persist($ownersTeam);
		$this->entityManager->flush();

        // Initialize the permissions:
        $this->getEventManager()->trigger('initializePermissions', $this);
        $this->entityManager->flush();

        // Create any entities that modules require:
        $this->getEventManager()->trigger('initializeEntities', $this);
        $this->entityManager->flush();
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

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager('CollabInstall');
        }
        return $this->eventManager;
    }

    public function addEntity($entity)
    {
        $this->entityManager->persist($entity);
    }

    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $name = $permission;

            $permission = new Permission();
            $permission->setName($name);
        }

        if (!$permission instanceof Permission) {
            throw new \RuntimeException('Expected a permission.');
        }

        $this->entityManager->persist($permission);
    }
}
