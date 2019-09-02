<?php

namespace App\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    const STATUS_PENDING_VALIDATION = "pending_activation";
    const STATUS_ENABLE = "enable";

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $email;

    /** @var array */
    private $roles;

    /** @var string */
    private $status;

    public function __construct(
        string $username,
        string $password,
        string $email,
        string $roles
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->roles[] = $roles;
        $this->status = self::STATUS_PENDING_VALIDATION;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function enable()
    {
        $this->status = self::STATUS_ENABLE;
    }
}
