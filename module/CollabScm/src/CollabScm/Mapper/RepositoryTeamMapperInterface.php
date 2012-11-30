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
use CollabScm\Entity\RepositoryTeam;

interface RepositoryTeamMapperInterface
{
    public function clearForRepository(Repository $repository);
    public function findBy(array $criteria);
    public function findById($id);
    public function persist(RepositoryTeam $repositoryTeam);
    public function remove(RepositoryTeam $repositoryTeam);
}
