<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z56;
use NFePHP\Sintegra\Elements\Z57;
use NFePHP\Sintegra\Elements\Z60A;
use NFePHP\Sintegra\Elements\Z60D;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z60D(
        new \DateTime('2023-05-26'),
        '4224',
        '1',
        1,
        10,
        10,
        4,
        40,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
