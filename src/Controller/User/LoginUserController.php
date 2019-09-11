<?php

namespace App\Controller\User;

use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class LoginUserController
{
    /** @var Environment */
    private $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @Route("/connection", name="login")
     */
    public function login()
    {

    }
}
