<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z56;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z56(
        '66291561000103',
        '01',
        '099',
        1354,
        5643,
        '101',
        1,
        'ff342',
        2,
        '99999090910270',
        10.00,
        '20050502200505021',
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
