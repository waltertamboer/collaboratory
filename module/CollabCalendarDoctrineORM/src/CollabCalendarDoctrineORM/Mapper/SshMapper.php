<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace ApplicationDoctrineORM\Mapper;

use Application\Entity\SshKey;
use Application\Mapper\SshMapperInterface;
use Doctrine\ORM\EntityManager;

class SshMapper implements SshMapperInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(SshKey $key)
    {
        $this->entityManager->persist($key);
        $this->entityManager->flush();

        return $this;
    }

    public function remove(SshKey $key)
    {
        $this->entityManager->remove($key);
        $this->entityManager->flush();

        return $this;
    }
}
