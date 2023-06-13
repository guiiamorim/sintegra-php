<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class CpfCnpj extends Constraint
{
    public string $message = 'O CPF / CNPJ "{{ document }}" é inválido ou falso.';
}
