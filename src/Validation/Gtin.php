<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
final class Gtin extends Constraint
{
    public string $message = 'O código de barras "{{ document }}" é inválido.';
    public ?string $path = null;

    #[HasNamedArguments]
    public function __construct(
        ?string $path = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
        $this->path = $path;
    }
}
