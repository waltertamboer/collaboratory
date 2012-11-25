<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabApplicationDoctrineORM\Mapper;

use CollabApplication\Entity\ApplicationEvent;
use CollabApplication\Mapper\ApplicationEventsMapperInterface;
use Doctrine\ORM\EntityManager;

class ApplicationEvents implements ApplicationEventsMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = $this->entityManager->getRepository('CollabApplication\Entity\ApplicationEvent');

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function persist(ApplicationEvent $applicationEvent)
    {
        $this->entityManager->persist($applicationEvent);
        $this->entityManager->flush();
    }

    public function remove(ApplicationEvent $applicationEvent)
    {
        $this->entityManager->remove($applicationEvent);
        $this->entityManager->flush();
    }
}
