<?php

namespace NFePHP\Sintegra\Tests\Unit;

use NFePHP\Sintegra\Blocks\Block1;
use NFePHP\Sintegra\Blocks\Block5;
use NFePHP\Sintegra\Elements\Z10;
use NFePHP\Sintegra\Elements\Z11;
use NFePHP\Sintegra\Elements\Z50;
use NFePHP\Sintegra\Sintegra;

test('Sintegra class is created correctly.', function () {
    $block1 = new Block1();
    $block1
        ->addElement(
            new Z10(
                '50795722052',
                '126199884',
                'FULANO DE TAL LTDA',
                'BREJO SECO',
                'MA',
                new \DateTime('2023-03-01'),
                new \DateTime('2023-03-31'),
                2,
                3,
                1,
            )
        )
        ->addElement(
            new Z11(
                '3335221245',
                'RUA DO OUVIDOR',
                '12345-678',
                '100',
                contato: 'FULANO DE TAL',
            )
        );
    $block5 = new Block5();
    for ($i = 0; $i < 10; $i++) {
        $block5->addElement(
            new Z50(
                '50795722052',
                new \DateTime('2023-03-01'),
                'MG',
                '55',
                1,
                $i,
                1320,
                'P',
                100,
                10,
                10,
                0,
                0,
                'N'
            )
        );
    }
    $sintegra = Sintegra::build([$block5, $block1]);
    $txt = (string) $sintegra;

    expect($sintegra)->toBeInstanceOf(Sintegra::class)
        ->and($txt)->toBeString();
});
