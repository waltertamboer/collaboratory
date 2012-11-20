<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSshDoctrineORM\Mapper;

use CollabSsh\Entity\SshKey;
use CollabSsh\Mapper\KeysMapperInterface;
use CollabUser\Entity\User;
use Doctrine\ORM\EntityManager;

class KeysMapper implements KeysMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        $repository = $this->entityManager->getRepository('CollabSsh\Entity\SshKey');

        return $repository->findAll();
    }

    public function findById($id)
    {
        $repository = $this->entityManager->getRepository('CollabSsh\Entity\SshKey');

        return $repository->find($id);
    }

    public function findForUser(User $user)
    {
        $repository = $this->entityManager->getRepository('CollabSsh\Entity\SshKey');

        return $repository->findBy(array(
            'createdBy' => $user->getId()
        ));
    }

    public function persist(SshKey $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(SshKey $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
