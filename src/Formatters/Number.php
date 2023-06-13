<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Formatters;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Number implements FormatterAttribute
{
    public const LENGTH_TOTAL = 0;
    public const LENGTH_PARTIAL = 1;

    /**
     * @throws \Exception
     */
    public function __construct(
        public readonly int $lenght,
        public readonly int $minDecimals = 0,
        public readonly int $maxDecimals = 0,
        public readonly string $default = '0',
        public readonly int $mode = Number::LENGTH_TOTAL,
    ) {
        if ($this->mode < self::LENGTH_TOTAL || $this->mode > self::LENGTH_PARTIAL) {
            throw new \Exception('Modo de formatação inválido.');
        }
    }

    /**
     * @throws \Exception
     */
    public function format(mixed $value): string
    {
        $maxDdecimals = max($this->minDecimals, $this->maxDecimals);
        $finalLenght = $this->lenght + ($maxDdecimals * $this->mode);
        if (! is_numeric($value)) {
            $value = preg_replace('/\D/', '', $value ?? '') ?: 0;
        }

        $formatter = new \NumberFormatter('pt_Br', \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $this->minDecimals);
        $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $maxDdecimals);
        $formatter->setSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL, '');
        $formatter->setSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL, '');
        $formatter->setAttribute(\NumberFormatter::FORMAT_WIDTH, $finalLenght);
        $formatter->setTextAttribute(\NumberFormatter::PADDING_CHARACTER, $this->default);
        $formatter->setAttribute(\NumberFormatter::PADDING_POSITION, \NumberFormatter::PAD_AFTER_PREFIX);

        $newValue = $formatter->format((float) $value);
        if (strlen($newValue) > $finalLenght) {
            throw new \Exception('Número maior que o permitido.');
        }

        return $newValue;
    }
}
