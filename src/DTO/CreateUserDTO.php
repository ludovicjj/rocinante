<?php

namespace App\DTO;

class CreateUserDTO
{
    /**
     * @var string|null
     */
    public $username;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var string|null
     */
    public $email;

    public function __construct(
        ?string $username,
        ?string $password,
        ?string $email
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
}
