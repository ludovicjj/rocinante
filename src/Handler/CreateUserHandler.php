<?php

namespace App\Handler;

use App\Builder\User\CreateUserBuilder;
use App\Entity\User;
use App\Helper\Mailer;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CreateUserHandler
{
    /** @var CreateUserBuilder */
    private $createUserBuilder;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var Mailer */
    private $mailer;

    public function __construct(
        CreateUserBuilder $createUserBuilder,
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        Mailer $mailer
    ) {
        $this->createUserBuilder = $createUserBuilder;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->mailer = $mailer;
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

            $this->flashBag->add(
                'success',
                sprintf('Un email de validation vous a été envoyé à %s', $user->getEmail())
            );

            $this->mailer->sendMail(
                $this->mailer::PARAMS_MAIL_APPLICATION,
                $user,
                'Rocinante - Inscription',
                'create_user'
            );

            return true;
        }

        return false;
    }
}
