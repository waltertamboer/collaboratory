<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScmDoctrineORM\Mapper;

use CollabScm\Entity\RepositoryTeam;
use CollabScm\Mapper\RepositoryTeamMapperInterface;
use Doctrine\ORM\EntityManager;

class RepositoryTeamMapper implements RepositoryTeamMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(array $criteria)
	{
        $repository = $this->entityManager->getRepository('CollabScm\Entity\RepositoryTeam');

        return $repository->findBy($criteria);
	}

    public function findById($id)
    {
        $repository = $this->entityManager->getRepository('CollabScm\Entity\RepositoryTeam');

        return $repository->find($id);
    }

    public function persist(RepositoryTeam $repositoryTeam)
    {
        $this->entityManager->persist($repositoryTeam);
        $this->entityManager->flush();

        return $this;
    }

    public function remove(RepositoryTeam $repositoryTeam)
    {
        $this->entityManager->remove($repositoryTeam);
        $this->entityManager->flush();

        return $this;
    }
}
