<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Formatters;

use NFePHP\Common\Strings;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Text implements FormatterAttribute
{
    /**
     * Formata valores alfanuméricos. Converte UTF-8 para ASCII, transforma em UPPERCASE e deixa a string com o tamanho
     * desejado (pode truncar a string!!)
     */
    public function __construct(
        public readonly int $length,
        public readonly string $default = ' ',
    ) {
    }

    public function format(mixed $value): string
    {
        $newValue = Strings::toASCII($value ?? '');
        return strtoupper(substr(str_pad($newValue, $this->length, $this->default), -$this->length));
    }
}
