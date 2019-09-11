<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Response;
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
     *
     * @return Response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function login()
    {
        return new Response(
            $this->twig->render(
                'user/login_user.html.twig',
                []
            )
        );
    }
}
