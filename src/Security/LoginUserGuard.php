<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginUserGuard extends AbstractFormLoginAuthenticator
{
    /** @var CsrfTokenManagerInterface */
    private $csrfTokenManager;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        EntityManagerInterface $entityManager,
        EncoderFactoryInterface $encoderFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // Get data login form

        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        // Define LAST_USERNAME
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // Check token
        $token = new CsrfToken('monsupertoken', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException('Token invalide');
        }

        // Check credential User
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $credentials['username']]);
        if (is_null($user)) {
            throw new CustomUserMessageAuthenticationException('Mauvais identifiant.');
        } elseif ($user->getStatus() !== 'enable') {
            throw new CustomUserMessageAuthenticationException('Ce compte n\'est pas encore activé.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Check password
        if (!$this->encoderFactory->getEncoder(User::class)
            ->isPasswordValid(
                $user,
                $credentials['password'],
                '')
        ) {
            throw new CustomUserMessageAuthenticationException('Mot de passe incorrect.');
        }

        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Redirection a la page d'accueil
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('login');
    }
}
