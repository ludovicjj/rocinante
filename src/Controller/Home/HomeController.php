<?php

namespace App\Controller\Home;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController
{
    /** @var Environment */
    private $twig;

    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="home")
     *
     * @return Response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function home()
    {
        return new Response(
            $this->twig->render(
                'home/home.html.twig',
                []
            )
        );
    }
}
