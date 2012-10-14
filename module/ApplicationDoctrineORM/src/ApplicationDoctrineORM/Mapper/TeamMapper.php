<?php
/**
 * This file is part of Collaboratory (https://github.com/nextphp/collaboratory)
 *
 * @link      https://github.com/nextphp/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 nextphp (https://github.com/nextphp)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace ApplicationDoctrineORM\Mapper;

use Application\Entity\Team;
use Application\Mapper\TeamMapperInterface;
use Doctrine\ORM\EntityManager;

class TeamMapper implements TeamMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll()
    {
        $repository = $this->entityManager->getRepository('Application\Entity\Team');

        return $repository->findAll();
    }

    public function getById($id)
    {
        $repository = $this->entityManager->getRepository('Application\Entity\Team');

        return $repository->find($id);
    }

    public function getByName($name)
    {
        $repository = $this->entityManager->getRepository('Application\Entity\Team');

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
