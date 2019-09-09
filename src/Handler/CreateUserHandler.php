<?php

namespace App\Handler;

use App\Builder\User\CreateUserBuilder;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class CreateUserHandler
{
    /** @var CreateUserBuilder */
    private $createUserBuilder;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        CreateUserBuilder $createUserBuilder,
        EntityManagerInterface $entityManager
    ) {
        $this->createUserBuilder = $createUserBuilder;
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $this->createUserBuilder->build($form->getData());

            /** @var UserRepository $userRepository */
            $userRepository = $this->entityManager->getRepository(User::class);
            $userRepository->persister($user);

            return true;
        }

        return false;
    }
}