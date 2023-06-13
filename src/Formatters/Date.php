<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Formatters;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Date implements FormatterAttribute
{
    public function __construct(
        public string $format = 'Ymd',
    ) {
    }

    /**
     * @throws \Exception
     */
    public function format(mixed $value): string
    {
        if (! $value instanceof \DateTime) {
            throw new \Exception('A data deve ser um objeto DateTime');
        }

        return $value->format($this->format);
    }
}
