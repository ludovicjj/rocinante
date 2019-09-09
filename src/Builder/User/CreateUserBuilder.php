<?php

namespace App\Builder\User;

use App\DTO\CreateUserDTO;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class CreateUserBuilder
{
    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param CreateUserDTO $dto
     * @return User
     * @throws \Exception
     */
    public function build(CreateUserDTO $dto): User
    {
        $user = new User(
            $dto->username,
            $this->encoderFactory->getEncoder(User::class)->encodePassword($dto->password, ''),
            $dto->email,
            'ROLE_USER'
        );

        return $user;
    }
}
