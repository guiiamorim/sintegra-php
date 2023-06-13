<?php

namespace NFePHP\Sintegra\Tests\Unit\Elements;

use NFePHP\Sintegra\Blocks\Block1;
use NFePHP\Sintegra\Common\Block;
use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Elements\Z10;
use NFePHP\Sintegra\Elements\Z11;

test('that it creates the class correctly and the output is correct.', function () {
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

    $txt = (string)$block1;

    expect($block1)->toBeInstanceOf(Block::class)
        ->and($block1->total())->toBe(2)
        ->and($txt)->toBeString();
});
