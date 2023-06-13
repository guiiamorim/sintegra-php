<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__DIR__) . '/vendor/autoload.php';

use NFePHP\Sintegra\Blocks\Block1;
use NFePHP\Sintegra\Blocks\Block5;
use NFePHP\Sintegra\Elements\Z10;
use NFePHP\Sintegra\Elements\Z11;
use NFePHP\Sintegra\Elements\Z50;
use NFePHP\Sintegra\Sintegra;

try {

    $block1 = new Block1();
    $block1
        ->addElement(
            new Z10(
                '50795722052',
                '126199884',
                'FULANO DE TAL LTDA',
                'BREJO SECO',
                'MA',
                new \DateTime('2023-05-01'),
                new \DateTime('2023-05-31'),
                3,
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
                '67899270000157',
                new \DateTime('2023-05-01'),
                'MA',
                '55',
                1,
                $i,
                5102,
                'P',
                100,
                10,
                10,
                0,
                0,
                'N'
            )
        )
        ->addElement(
            new \NFePHP\Sintegra\Elements\Z54(
                '67899270000157',
                '55',
                1,
                $i,
                5102,
                100,
                1,
                'teste',
                1,
                10,
                0,
                0,
                0,
            )
        );
    }

    $block7 = new \NFePHP\Sintegra\Blocks\Block7();
    $block7->addElement(
        new \NFePHP\Sintegra\Elements\Z75(
            new DateTime('2023-05-01'),
            new DateTime('2023-05-31'),
            'teste',
            '08101000',
            'morangos',
            'cx',
            0,
            0,
            0,
            0,
        )
    );
    $sintegra = Sintegra::build([$block5, $block1, $block7]);

    header("Content-Type: text/plain");
    echo $sintegra;

} catch (\NFePHP\Sintegra\Exceptions\ElementValidation $e) {
    echo $e->getMessage();
    dump($e->errors);
}
