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
 * The representation of a user.
 */
class User extends AbstractEntity
{
    /**
     * The email address of the user.
     *
     * @var string
     */
    private $email;

    /**
     * Gets the email of the user.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email of the user.
     *
     * @param string $email The email of the user to set.
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
