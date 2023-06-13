<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z11;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z11(
        '3335221245',
        'RUA DO OUVIDOR',
        '12345-678',
        '100',
        contato: 'FULANO DE TAL',
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
