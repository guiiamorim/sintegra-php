<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class ValidDate extends Constraint
{
    public const FIRST_DAY = 1;
    public const LAST_DAY = 0;

    public function __construct(
        public int $mode = ValidDate::FIRST_DAY,
        public string $message = 'A data informada é inválida.',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }
}
