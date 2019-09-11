<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixtures extends Fixture
{
    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $dataUsers = [
            [
                'username' => 'admin',
                'password' => 'admin',
                'email' => 'admin@gmail.com',
                'roles' => 'ROLE_ADMIN',
            ],
            [
                'username' => 'user',
                'password' => 'user',
                'email' => 'user@gmail.com',
                'roles' => 'ROLE_USER',
            ]
        ];

        foreach ($dataUsers as $dataUser) {
            $user = new User(
                $dataUser['username'],
                $this->encoderFactory->getEncoder(User::class)->encodePassword($dataUser['password'], ''),
                $dataUser['email'],
                $dataUser['roles']
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
