<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z10;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z10(
        '50795722052',
        '126199884',
        'FULANO DE TAL LTDA',
        'BREJO SECO',
        'MA',
        new \DateTime('2023-03-01'),
        new \DateTime('2023-03-31'),
        2,
        3,
        1,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
