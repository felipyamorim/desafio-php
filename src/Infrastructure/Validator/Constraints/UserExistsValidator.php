<?php

namespace App\Infrastructure\Validator\Constraints;

use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserExistsValidator extends ConstraintValidator
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}
    public function validate(mixed $value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if(!$this->userRepository->get($value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}