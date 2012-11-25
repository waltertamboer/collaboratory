<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Mapper;

use CollabScm\Entity\Repository;

interface RepositoryMapperInterface
{
    public function findBy(array $criteria);
    public function findById($id);
    public function persist(Repository $repository);
    public function remove(Repository $repository);
}
