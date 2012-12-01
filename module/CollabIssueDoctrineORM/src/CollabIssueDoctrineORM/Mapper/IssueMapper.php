<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabIssueDoctrineORM\Mapper;

use Doctrine\ORM\EntityManager;
use CollabIssue\Entity\Issue;
use CollabIssue\Mapper\MapperInterface;

class IssueMapper implements MapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(Issue $issue)
    {
        $this->entityManager->persist($issue);
        $this->entityManager->flush();
    }

    public function remove(Issue $issue)
    {
        $this->entityManager->remove($issue);
        $this->entityManager->flush();
    }
}
