<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once dirname(__DIR__) . '/vendor/autoload.php';

use NFePHP\Sintegra\Blocks\Block1;
use NFePHP\Sintegra\Elements\Z10;
use NFePHP\Sintegra\Elements\Z11;

try {
    $b1 = new Block1();
    $b1
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

    header("Content-Type: text/plain");
    echo $b1;

} catch (\NFePHP\Sintegra\Exceptions\ElementValidation $e) {
    echo $e->getMessage();
    dump($e->errors);
}
