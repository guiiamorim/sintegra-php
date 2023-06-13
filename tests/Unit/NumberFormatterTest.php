<?php

namespace NFePHP\Sintegra\Tests\Unit;

use NFePHP\Sintegra\Formatters\Number;

test('numbers are formatted correctly with decimals.', function () {
    $numberFormatter = new Number(5);

    $formatted = $numberFormatter->format(100);

    expect($formatted)
        ->toBeString()
        ->toHaveLength(5);
});

test('numbers are formatted correctly without decimals.', function () {
    $numberFormatter = new Number(11);

    $formatted = $numberFormatter->format(123.248);

    expect($formatted)
        ->toBeString()
        ->toHaveLength(11);
});

test('numbers are formatted correctly with minimum and maximum decimals.', function () {
    $numberFormatter = new Number(11, 2, 4);

    $formatted = $numberFormatter->format(123.248);

    expect($formatted)
        ->toBeString()
        ->toHaveLength(11);
});

test('works with null values.', function () {
    $numberFormatter = new Number(11, 2, 4);

    $formatted = $numberFormatter->format(null);

    expect($formatted)
        ->toBeString()
        ->toHaveLength(11);
});
