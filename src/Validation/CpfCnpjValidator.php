<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Cpf;
use Symfony\Component\Validator\Constraint;

final class CpfCnpjValidator extends \Symfony\Component\Validator\ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! Cpf::createFromString($value) && ! Cnpj::createFromString($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ document }}', $value)
                ->addViolation();
        }
    }
}
