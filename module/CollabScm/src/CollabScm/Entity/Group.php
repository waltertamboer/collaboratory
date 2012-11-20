<?php
/**
 * This file is part of Collaboratory (https://github.com/pixelpolishers/collaboratory)
 *
 * @link      https://github.com/pixelpolishers/collaboratory for the canonical source repository
 * @copyright Copyright (c) 2012 Pixel Polishers (https://github.com/pixelpolishers)
 * @license   For the full copyright and license information, view the LICENSE file.
 * @package   Collaboratory
 */

namespace CollabScm\Entity;

/**
 * The representation of a group.
 */
class Group extends AbstractEntity
{
    /**
     * Gets the name of the entity.
     *
     * @return string
     */
    public function getName()
    {
        return '@' . parent::getName();
    }
}
