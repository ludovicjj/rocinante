<?php

namespace App\Controller\User;

use App\Form\CreateUserType;
use App\Handler\CreateUserHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class CreateUserController
{
    /** @var Environment */
    private $twig;

    /** @var FormFactoryInterface */
    private $FormFactory;

    /** @var CreateUserHandler */
    private $createUserHandler;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        CreateUserHandler $createUserHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->FormFactory = $formFactory;
        $this->twig = $twig;
        $this->createUserHandler = $createUserHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/registration", name="create_user")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = $this->FormFactory->create(CreateUserType::class)->handleRequest($request);

        if ($this->createUserHandler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('home')
            );
        }

        return new Response(
            $this->twig->render(
                'user/create_user.html.twig',
                [
                    'form' => $form->createView(),
                ]
            )
        );
    }
}
