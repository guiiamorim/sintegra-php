<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z53;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z53(
        '66291561000103',
        new \DateTime('2023-03-20'),
        'MG',
        '55',
        '123',
        '612047',
        '6102',
        'P',
        300.2223,
        30.594,
        0,
        'N',
        inscricaoEstadual: '283305054',
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
