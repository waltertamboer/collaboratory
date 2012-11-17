<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabUserDoctrineORM\Mapper;

use CollabUser\Entity\User;
use CollabUser\Mapper\UserMapperInterface;
use Doctrine\ORM\EntityManager;

class UserMapper implements UserMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAjax($query)
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\User');

        $qb = $repository->createQueryBuilder('e');
        $qb->add('select', 'u');
        $qb->add('from', 'CollabUser\Entity\User u');
        $qb->add('where', $qb->expr()->like('u.identity', $qb->expr()->literal('%' . $query . '%')));

        $result = array();
        foreach ($qb->getQuery()->getResult() as $entity) {
            $result[] = array(
                'id' => $entity->getId(),
                'identity' => $entity->getIdentity(),
                'displayName' => $entity->getDisplayName(),
            );
        }
        return $result;
    }

    public function findAll()
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\User');

        return $repository->findAll();
    }

    public function findByEmail($email)
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\User');

        return $repository->findOneBy(array(
                'identity' => $email
            ));
    }

    public function findById($id)
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\User');

        return $repository->find($id);
    }

    public function persist(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
