<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabProjectDoctrineORM\Mapper;

use CollabProject\Entity\Project;
use CollabProject\Mapper\ProjectMapperInterface;
use Doctrine\ORM\EntityManager;

class ProjectMapper implements ProjectMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll()
    {
        $repository = $this->entityManager->getRepository('CollabProject\Entity\Project');

        return $repository->findAll();
    }

    public function getById($id)
    {
        $repository = $this->entityManager->getRepository('CollabProject\Entity\Project');

        return $repository->find($id);
    }

    public function getByName($name)
    {
        $repository = $this->entityManager->getRepository('CollabProject\Entity\Project');

        return $repository->findOneBy(array('name' => $name));
    }

    public function persist(Project $project)
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this;
    }

    public function remove(Project $project)
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return $this;
    }
}
