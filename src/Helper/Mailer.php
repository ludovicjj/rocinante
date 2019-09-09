<?php

namespace App\Helper;

use App\Entity\User;
use Twig\Environment;

class Mailer
{
    /** @var Environment */
    private $twig;

    /** @var \Swift_Mailer */
    private $mailer;

    public function __construct(
        Environment $twig,
        \Swift_Mailer $mailer
    ) {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * @param User $user
     * @param string $subject
     * @param string $template
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendMail(
        User $user,
        string $subject,
        string $template
    )
    {
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom('jahanlud@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('email/'.$template.'.html.twig', [
                    'username' => $user->getUsername(),
                    'token' => $user->getId()
                ]),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}
