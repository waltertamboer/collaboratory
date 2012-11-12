<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
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

        $user = new \CollabUser\Entity\User();
        $user->setIdentity('walter.tamboer@live.com');
        $user->setCredential('$2y$14$/ACQfLrUGo8a/sN59uxnGuwtJXqYytA35bPctziBuZv0hpRoegcJC');
        $user->setDisplayName('Walter Tamboer');

        $entityManager->persist($user);
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
        if (!$this->userAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('user/login');
        }

        return new ViewModel();
    }
}
