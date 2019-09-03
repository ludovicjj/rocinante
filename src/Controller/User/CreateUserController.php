<?php

namespace App\Controller\User;

use App\Form\CreateUserType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CreateUserController
{
    /** @var Environment */
    private $twig;

    /** @var FormFactoryInterface */
    private $FormFactory;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig
    ) {
        $this->FormFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @Route("/registration", name="create_user")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function create(Request $request)
    {
        $form = $this->FormFactory->create(CreateUserType::class)->handleRequest($request);

        return new Response(
            $this->twig->render(
                '',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}