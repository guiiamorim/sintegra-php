<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Exceptions;

final class ElementNotFound extends \Exception
{
    public function __construct(string $message = 'Não foi encontrado nenhum elemento nesta posição.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
