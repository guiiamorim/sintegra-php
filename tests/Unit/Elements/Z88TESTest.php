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
use NFePHP\Sintegra\Elements\Z76;
use NFePHP\Sintegra\Elements\Z77;
use NFePHP\Sintegra\Elements\Z85;
use NFePHP\Sintegra\Elements\Z86;
use NFePHP\Sintegra\Elements\Z88DV;
use NFePHP\Sintegra\Elements\Z88EAN;
use NFePHP\Sintegra\Elements\Z88SME;
use NFePHP\Sintegra\Elements\Z88SMS;
use NFePHP\Sintegra\Elements\Z88STES;

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z88STES(
        '99999090910270',
        new \DateTime('20230526'),
        '1313531',
        1,
        0,
        0,
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
