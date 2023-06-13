<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Exceptions;

use Throwable;

final class ElementNotAllowed extends \Exception
{
    public function __construct(string $block, string $element, int $code = 0, ?Throwable $previous = null)
    {
        $message = sprintf('Elemento do tipo [ %s ] não permitido para o bloco [ %s ]', $element, $block);
        parent::__construct($message, $code, $previous);
    }
}
