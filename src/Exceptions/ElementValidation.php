<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

final class ElementValidation extends \Exception
{
    /**
     * @param ConstraintViolationListInterface|array<string> $errors
     */
    public function __construct(
        string $message = 'Há erros de validação no elemento.',
        int $code = 0,
        public readonly ConstraintViolationListInterface|array $errors = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
