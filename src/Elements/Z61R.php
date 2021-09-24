<?php

namespace NFePHP\Sintegra\Elements;

/**
 * Resumo mensal - Registro de mercadoria/produto ou serviço comercializados
 * através de Nota Fiscal de Produtor ou Nota Fiscal de Venda a Consumidor
 * não emitida por ECF.
 */

use NFePHP\Sintegra\Common\Element;
use NFePHP\Sintegra\Common\ElementInterface;
use \stdClass;

class Z61R extends Element implements ElementInterface
{
    const REGISTRO = '61';

    protected $parameters = [
        'MESTRE' => [
            'type' => 'string',
            'regex' => '^.{1}$',
            'required' => true,
            'info' => 'Mestre/Analítico/Resumo',
            'format' => '',
            'length' => 1
        ],
        'PERIODO_EMISSAO' => [
            'type' => 'string',
            'regex' => '^(2[0-9]{3})(0?[1-9]|1[012])$',
            'required' => false,
            'info' => 'Mês e Ano de emissão dos documentos fiscais',
            'format' => '',
            'length' => 6
        ],
        'COD_PRODUTO' => [
            'type' => 'string',
            'regex' => '^.{1,14}$',
            'required' => true,
            'info' => 'Código do produto do informante',
            'format' => 'empty',
            'length' => 14
        ],
        'QUANTIDADE' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Quantidade do produto acumulada vendida no mês (com 3 decimais)',
            'format' => '10v3',
            'length' => 13
        ],
        'VALOR_PRODUTO' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => false,
            'info' => 'Valor bruto do produto - valor acumulado da venda do produto no mês (com 2 decimais)',
            'format' => '14v2',
            'length' => 16
        ],
        'VL_BC_ICMS' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Base de cálculo do ICMS do valor acumulado no mês (com 2 decimais)',
            'format' => '14v2',
            'length' => 16
        ],
        'ALIQUOTA' => [
            'type' => 'numeric',
            'regex' => '^\d+(\.\d*)?|\.\d+$',
            'required' => true,
            'info' => 'Alíquota Utilizada no Cálculo do ICMS (com 2 decimais)',
            'format' => '2v2',
            'length' => 4
        ],
        'BRANCOS' => [
            'type' => 'string',
            'regex' => '^[0-9]{1}$',
            'required' => false,
            'info' => 'Brancos',
            'format' => 'empty',
            'length' => 53
        ]
    ];

    /**
     * Constructor
     * @param \stdClass $std
     */
    public function __construct(\stdClass $std)
    {
        parent::__construct(self::REGISTRO);
        $std->MESTRE = 'R';
        $this->std = $this->standarize($std);
    }
}
