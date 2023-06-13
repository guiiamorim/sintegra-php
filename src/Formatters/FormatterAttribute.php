<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Formatters;

interface FormatterAttribute
{
    public function format(mixed $value): string;
}
