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

use CollabUser\Entity\Permission;
use CollabUser\Mapper\PermissionMapperInterface;
use Doctrine\ORM\EntityManager;

class PermissionMapper implements PermissionMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository('CollabUser\Entity\Permission');

        return $repository->find($id);
    }
}
