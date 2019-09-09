<?php

namespace App\Handler;

use App\Builder\User\CreateUserBuilder;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;

class CreateUserHandler
{
    /** @var CreateUserBuilder */
    private $createUserBuilder;

    public function __construct(
        CreateUserBuilder $createUserBuilder
    ) {
        $this->createUserBuilder = $createUserBuilder;
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

            return true;
        }

        return false;
    }
}