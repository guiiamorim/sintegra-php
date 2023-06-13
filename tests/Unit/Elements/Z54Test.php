<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z54;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z54(
        '66291561000103',
        55,
        '099',
        612047,
        6102,
        '010',
        1,
        'MG42321',
        1,
        5000.00,
        5000.00,
        0.00,
        10.00,
        0.00,
        10.00,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
