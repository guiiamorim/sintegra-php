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

test('that it creates the class correctly and the output is correct.', function () {
    $elem = new Z71(
        '99999090910270',
        new \DateTime('2023-03-20'),
        'PR',
        '01',
        1,
        1,
        'PR',
        66291561000103,
        new \DateTime('2023-03-20'),
        55,
        1,
        1000,
        100,
        inscricaoEstadualTomador: '283305054',
        inscricaoEstadualRemetente: '283305054',
    );
    $txt = (string)$elem;

    expect($elem)->toBeInstanceOf(Element::class)
        ->and($txt)->toBeString()->toHaveLength(126);
});
