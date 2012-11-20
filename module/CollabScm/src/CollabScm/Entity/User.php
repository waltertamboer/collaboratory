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
 * The representation of a user within Gitolite.
 */
class User
{
    /**
     * The username of the user.
     *
     * @var string
     */
    private $username;

    /**
     * The email address of the user.
     *
     * @var string
     */
    private $email;

    /**
     * Gets the username of the user.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username of the user.
     *
     * @param string $username The username of the user to set.
     * @return Repository
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

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
     * @return Repository
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
