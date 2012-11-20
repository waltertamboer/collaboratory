<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DashboardController extends AbstractActionController
{
    public function dbAction()
    {
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // All the meta data of the system:
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();

        // Drop the current schema and create a new one:
        $tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $tool->dropDatabase();
        $tool->createSchema($metaData);

        // Generating the proxy classes for the entities:
        $destPath = getcwd() . '/data/DoctrineORMModule/Proxy';
        $entityManager->getProxyFactory()->generateProxyClasses($metaData, $destPath);

        $adminUser = new \CollabUser\Entity\User();
        $adminUser->setIdentity('walter.tamboer@live.com');
        $adminUser->setCredential('$2y$14$/ACQfLrUGo8a/sN59uxnGuwtJXqYytA35bPctziBuZv0hpRoegcJC');
        $adminUser->setDisplayName('Walter Tamboer');

        $entityManager->persist($adminUser);

        for ($i = 1; $i <= 10; ++$i) {
            $user = new \CollabUser\Entity\User();
            $user->setIdentity('test' . $i . '@test.com');
            $user->setCredential('$2y$14$/ACQfLrUGo8a/sN59uxnGuwtJXqYytA35bPctziBuZv0hpRoegcJC');
            $user->setDisplayName('Test User ' . $i);

            $entityManager->persist($user);
        }

        for ($i = 1; $i <= 5; ++$i) {
            $team = new \CollabTeam\Entity\Team();
            $team->setName('Team ' . $i);
            $team->setDescription('This is team number ' . $i);
			$team->addMember($adminUser);

            $entityManager->persist($team);
        }

        for ($i = 1; $i <= 5; ++$i) {
            $project = new \CollabProject\Entity\Project();
            $project->setName('Project ' . $i);
            $project->setDescription('This is project number ' . $i);

            $entityManager->persist($project);
        }

        $entityManager->flush();

        //$cme = new \Doctrine\ORM\Tools\Export\ClassMetadataExporter();
        //$destPath = getcwd() . '/data/test';
        //$exporter = $cme->getExporter('yml', $destPath);
        //$exporter->setMetadata($classes);
        //$exporter->export();

        echo '<pre>';
        echo 'Done!';
        exit;
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
