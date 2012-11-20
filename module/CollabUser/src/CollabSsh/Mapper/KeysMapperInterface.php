<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabSsh\Mapper;

use CollabSsh\Entity\SshKey;
use CollabUser\Entity\User;

interface KeysMapperInterface
{
    public function findAll();
    public function findById($id);
    public function findForUser(User $user);
    public function persist(SshKey $key);
    public function remove(SshKey $key);
}
