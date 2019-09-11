<?php

namespace App\Validator\CreateUser;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Doctrine\ORM\EntityManagerInterface;

class UniqueEntityValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function validate(
        $value,
        Constraint $constraint
    ) {
        if (!$constraint instanceof UniqueEntity) {
            throw new UnexpectedTypeException($constraint, UniqueEntity::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $fields = (array) $constraint->fields;

        foreach ($fields as $field) {
            $fieldValue = $value->{$field};


            $entity = $this->entityManager->getRepository($constraint->class)
                ->findOneBy(
                    [
                        $field => $fieldValue
                    ]
                )
            ;

            if (!\is_null($entity)) {
                $this->context->buildViolation($constraint->message[$field])
                    ->atPath($field)
                    ->addViolation()
                ;
            }
        }
    }
}
