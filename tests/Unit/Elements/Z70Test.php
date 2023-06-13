<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z56;
use NFePHP\Sintegra\Elements\Z57;
use NFePHP\Sintegra\Elements\Z60A;
use NFePHP\Sintegra\Elements\Z60D;
use NFePHP\Sintegra\Elements\Z60I;
use NFePHP\Sintegra\Elements\Z60M;
use NFePHP\Sintegra\Elements\Z60R;
use NFePHP\Sintegra\Elements\Z61;
use NFePHP\Sintegra\Elements\Z70;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z70(
        '66291561000103',
        new \DateTime('2023-03-20'),
        'MG',
        '55',
        '1',
        '612047',
        '6102',
        300.2223,
        300.594,
        24.393939,
        0,
        0,
        'N',
        inscricaoEstadual: '283305054',
        subserie: 'a',
        outrosValores: 0,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
