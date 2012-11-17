<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
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

    public function findAjax($query)
    {
        $repository = $this->entityManager->getRepository('CollabProject\Entity\Project');

        $qb = $repository->createQueryBuilder('e');
        $qb->add('select', 'p');
        $qb->add('from', 'CollabProject\Entity\Project p');
        $qb->add('where', $qb->expr()->like('p.name', $qb->expr()->literal('%' . $query . '%')));

        $result = array();
        foreach ($qb->getQuery()->getResult() as $entity) {
            $result[] = array(
                'id' => $entity->getId(),
                'name' => $entity->getName(),
            );
        }
        return $result;
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
