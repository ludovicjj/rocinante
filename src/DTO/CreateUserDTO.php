<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\CreateUser\UniqueEntity;

/**
 * Class CreateUserDTO
 * @UniqueEntity(
 *     class="App\Entity\User",
 *     fields={"username", "email"},
 *     message={"username" : "Ce pseudo est déjà utilisé.", "email" : "Cette email est déjà utilisée."}
 * )
 */
class CreateUserDTO
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Vous devez saisir un nom pseudo.")
     * @Assert\Length(
     *     max=30,
     *     maxMessage="Votre pseudo ne peut pas excéder {{ limit }} caractéres."
     * )
     */
    public $username;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe.")
     * @Assert\Length(
     *     max=50,
     *     maxMessage="Votre mot de passe ne peut pas excéder {{ limit }} caractéres."
     * )
     */
    public $password;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Length(
     *     max=60,
     *     maxMessage="Votre adresse email ne peut pas excéder {{ limit }} caractéres."
     * )
     * @Assert\Email(message="Le format de l'adresse email n'est pas correcte.")
     */
    public $email;

    public function __construct(
        ?string $username,
        ?string $password,
        ?string $email
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
}
