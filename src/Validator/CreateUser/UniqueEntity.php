<?php

namespace App\Validator\CreateUser;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueEntity
 *
 * @Annotation
 */
class UniqueEntity extends Constraint
{
    /** @var array */
    public $message = [];

    /** @var array */
    public $fields = [];

    /** @var string */
    public $class;

    public function getRequiredOptions()
    {
        return [
            'fields',
            'class',
            'message'
        ];
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
