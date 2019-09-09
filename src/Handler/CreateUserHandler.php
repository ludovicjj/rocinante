<?php

namespace App\Handler;

use Symfony\Component\Form\FormInterface;

class CreateUserHandler
{
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {

            return true;
        }

        return false;
    }
}