<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Symfony\Component\Validator\Constraint;

final class ValidDateValidator extends \Symfony\Component\Validator\ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! $value instanceof \DateTime) {
            return;
        }

        if ($constraint->mode === ValidDate::FIRST_DAY) {
            if ($value->format('d') > 1) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
            return;
        }

        $lastday = date('Ymt', strtotime($value->format('Y-m-d')));
        if ($lastday !== $value->format('Ymd')) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
