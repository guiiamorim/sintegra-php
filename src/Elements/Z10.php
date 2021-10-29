<?php

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 * @package   NFePHP\Sintegra
 * @copyright 2019 NFePHP Copyright (c)
 * @license   https://opensource.org/licenses/MIT MIT
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 * @link      http://github.com/nfephp-org/sped-sintegra
 */

namespace NFePHP\Sintegra\Elements;

use NFePHP\Sintegra\Common\Element;

class Z10 extends Element
{
    const REGISTRO = '10';

    protected $parameters = [
        'CNPJ' => [
            'type' => 'numeric',
            'regex' => '^[0-9]{11,14}$',
            'required' => true,
            'info' => 'Número de inscrição do estabelecimento matriz da pessoa jurídica no CNPJ ou CPF.',
            'format' => 'totalNumber',
            'length' => 14
        ],
        'IE' => [
            'type' => 'string',
            'regex' => '^ISENTO|[0-9]{0,14}$',
            'required' => false,
            'info' => 'Número de inscrição do estadual.',
            'format' => '',
            'length' => 14
        ],
        'NOME_CONTRIBUINTE' => [
            'type' => 'string',
            'regex' => '^.{2,35}$',
            'required' => true,
            'info' => 'Nome comercial (razao social)',
            'format' => '',
            'length' => 35
        ],
        'MUNICIPIO' => [
            'type' => 'string',
            'regex' => '^.{2,30}$',
            'required' => true,
            'info' => 'Municipio do estabelecimento',
            'format' => '',
            'length' => 30
        ],
        'UF' => [
            'type' => 'string',
            'regex' => '^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$',
            'required' => true,
            'info' => 'Sigla da Unidade da Federação da pessoa',
            'format' => '',
            'length' => 2
        ],
        'FAX' => [
            'type' => 'string',
            'regex' => '^[0-9]{5,10}$',
            'required' => false,
            'info' => 'Telefone do estabelicimento',
            'format' => 'totalNumber',
            'length' => 10
        ],
        'DT_INI' => [
            'type' => 'string',
            'regex' => '^(2[0-9]{3})(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$',
            'required' => true,
            'info' => 'Data inicial das informações contidas no arquivo.',
            'format' => '',
            'length' => 8
        ],
        'DT_FIM' => [
            'type' => 'string',
            'regex' => '^(2[0-9]{3})(0?[1-9]|1[012])(0?[1-9]|[12][0-9]|3[01])$',
            'required' => true,
            'info' => 'Data final das informações contidas no arquivo.',
            'format' => '',
            'length' => 8
        ],
        'COGIGO_MAGNETICO' => [
            'type' => 'numeric',
            'regex' => '^(1|2|3)$',
            'required' => true,
            'info' => 'Código da identificação da estrutura do arquivo magnético entregue',
            'format' => '',
            'length' => 1
        ],
        'COGIGO_NATUREZAS' => [
            'type' => 'numeric',
            'regex' => '^(1|2|3)$',
            'required' => true,
            'info' => 'Código da identificação da natureza das operações informadas',
            'format' => '',
            'length' => 1
        ],
        'COGIGO_FINALIDADE' => [
            'type' => 'numeric',
            'regex' => '^(1|2|3|5)$',
            'required' => true,
            'info' => 'Código da finalidade do arquivo magnético',
            'format' => '',
            'length' => 1
        ],
    ];

    /**
     * Constructor
     * @param \stdClass $std
     */
    public function __construct(\stdClass $std)
    {
        parent::__construct(self::REGISTRO);
        $this->std = $this->standarize($std);
        $this->postValidation();
    }

    /**
     * Validação secundária sobre as data informadas
     *
     * @return void
     */
    public function postValidation()
    {
        $dini = \DateTime::createFromFormat('Ymd', $this->std->dt_ini);
        $dfim = \DateTime::createFromFormat('Ymd', $this->std->dt_fim);
        if ($dini === false) {
            $this->errors[] = (object) [
                'message' => "[$this->reg] campo: DT_INI náo é uma data no formato esperado.",
                'std' => $this->std
            ];
            return;
        }
        $lastday = date("Ymt", strtotime($dini->format('Y-m-d')));
        if ($dfim <= $dini) {
            $this->errors[] = (object) [
                'message' => "[$this->reg] campo: DT_FIM A data final deve "
                . "ser maior que a data inicial.",
                'std' => $this->std
            ];
        }
        if ($this->std->dt_fim != $lastday) {
            $this->errors[] = (object) [
                'message' => "[$this->reg] campo: DT_FIM A data final deve "
                . "ser o último dia do mês indicado na data inicial.",
                'std' => $this->std
            ];
        }
        //valida o CNPJ/CPF informado
        $resp = \Brazanation\Documents\Cnpj::createFromString($this->std->cnpj);
        if ($resp === false) {
            $resp = \Brazanation\Documents\Cpf::createFromString(substr($this->std->cnpj, -11));
            if ($resp === false) {
                $this->errors[] = (object) [
                    'message' => "[$this->reg] campo: CNPJ/CPF É inválido.",
                    'std' => $this->std
                ];
            }
        }
    }
}
