<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z55;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z55(
        '66291561000103',
        new \DateTime('2023-03-20'),
        'MG',
        'MG',
        001,
        '123',
        '612047',
        100.00,
        new \DateTime('2023-03-20'),
        new \DateTime('2023-03'),
        '200505',
        inscricaoEstadual: '283305054',
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
