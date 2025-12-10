<?php

namespace App\Validator;

use UnexpectedValueException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class InputValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Input $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $counts = count_chars($value, 1);

        foreach ($counts as $ascii => $count)
        {
            if($count != 2){
                $letter = chr($ascii);
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ letter }}', $letter)
                    ->setParameter('{{ count }}', $count)
                    ->addViolation()
                ;

            }
        }

    }
}
