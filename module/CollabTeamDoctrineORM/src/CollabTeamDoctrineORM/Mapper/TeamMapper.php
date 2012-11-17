<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabTeamDoctrineORM\Mapper;

use CollabTeam\Entity\Team;
use CollabTeam\Mapper\TeamMapperInterface;
use Doctrine\ORM\EntityManager;

class TeamMapper implements TeamMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAjax($query)
    {
        $repository = $this->entityManager->getRepository('CollabTeam\Entity\Team');

        $qb = $repository->createQueryBuilder('e');
        $qb->add('select', 't');
        $qb->add('from', 'CollabTeam\Entity\Team t');
        $qb->add('where', $qb->expr()->like('t.name', $qb->expr()->literal('%' . $query . '%')));

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
        $repository = $this->entityManager->getRepository('CollabTeam\Entity\Team');

        return $repository->findAll();
    }

    public function getById($id)
    {
        $repository = $this->entityManager->getRepository('CollabTeam\Entity\Team');

        return $repository->find($id);
    }

    public function getByName($name)
    {
        $repository = $this->entityManager->getRepository('CollabTeam\Entity\Team');

        return $repository->findOneBy(array('name' => $name));
    }

    public function persist(Team $team)
    {
        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $this;
    }

    public function remove(Team $team)
    {
        $this->entityManager->remove($team);
        $this->entityManager->flush();

        return $this;
    }
}
