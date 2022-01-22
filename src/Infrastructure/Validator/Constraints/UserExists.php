<?php

namespace App\Infrastructure\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UserExists extends Constraint
{
    public $message = 'The user does not exist.';
}