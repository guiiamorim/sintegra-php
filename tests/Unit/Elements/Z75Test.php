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
use NFePHP\Sintegra\Elements\Z71;
use NFePHP\Sintegra\Elements\Z74;
use NFePHP\Sintegra\Elements\Z75;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z75(
        new \DateTime('2023-03-20'),
        new \DateTime('2023-03-20'),
        'rwwfd',
        '1.343.23',
        'produto teste',
        'un',
        0,
        0,
        0,
        0,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
