<?php

declare(strict_types=1);

/**
 * This file belongs to the NFePHP project
 * php version 7.0 or higher
 *
 * @category  Library
 *
 * @package   NFePHP\Sintegra
 *
 * @copyright 2019 NFePHP Copyright (c)
 *
 * @license   https://opensource.org/licenses/MIT MIT
 *
 * @author    Roberto L. Machado <linux.rlm@gmail.com>
 *
 * @link      http://github.com/nfephp-org/sped-sintegra
 */

namespace NFePHP\Sintegra\Elements;

/**
 * Serviços de comunicação e telecomunicação
 */

use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z77 extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'O modelo da nota fiscal é obrigatório.')]
    #[Assert\Choice(
        choices: [
            '01', //01 - Nota Fiscal, modelo 1
            '02', //02 - Nota Fiscal de Venda a Consumidor, modelo 02
            '03', //03 - Nota Fiscal de Entrada, modelo 3
            '04', //04 - Nota Fiscal de Produtor, modelo 4
            '06', //06 - Nota Fiscal/Conta de Energia Elétrica, modelo 6
            '07', //07 - Nota Fiscal de Serviço de Transporte, modelo 7
            '08', //08 - Conhecimento de Transporte Rodoviário de Cargas, modelo 8
            '09', //09 - Conhecimento de Transporte Aquaviário de Cargas, modelo 9
            '10', //10 - Conhecimento Aéreo, modelo 10
            '11', //11 - Conhecimento de Transporte Ferroviário de Cargas, modelo 11
            '13', //13 - Bilhete de Passagem Rodoviário, modelo 13
            '14', //14 - Bilhete de Passagem Aquaviário, modelo 14
            '15', //15 - Bilhete de Passagem e Nota de Bagagem, modelo 15
            '16', //16 - Bilhete de Passagem Ferroviário, modelo 16
            '17', //17 - Despacho de Transporte, modelo 17
            '18', //18 - Resumo Movimento Diário, modelo 18
            '20', //20 - Ordem de Coleta de Carga, modelo 20
            '21', //21 - Nota Fiscal de Serviço de Comunicação, modelo 21
            '22', //22 - Nota Fiscal de Serviço de Telecomunicações, modelo 22
            '24', //24 - Autorização de Carregamento e Transporte, modelo 24
            '25', //25 - Manifesto de Carga, modelo 25
            '26', //26 - Conhecimento de Transporte Multimodal de Cargas, modelo 26
            '27', //27 - Nota Fiscal de Serviço de Transporte Ferroviário, modelo 27
            '55', //55 - Nota Fiscal Eletrônica, modelo 55
            '57', //57 - Conhecimento de Transporte Eletrônico, modelo 57
            '60', //60 - Cupom Fiscal Eletrônico, CF-e- ECF, modelo 60
            '63', //63 - Bilhete de Passagem Eletrônico, modelo 63
            '65', //65 - Nota Fiscal de Consumidor Eletrônica, modelo 65
            '66', //66 - NOta Fiscal Energia Eletrica Eletrônica, modelo 66
            '67', //67 - Conhecimento de Transporte Eletrônico para Outros Serviços, modelo 67
        ],
        message: 'Modelo da nota fiscal inválido.',
    )]
    protected string $codigoModelo;

    #[Assert\NotBlank(message: 'A série do documento fiscal é obrigatória.')]
    #[Assert\Regex('/^\d{1,2}$/', message: 'A série do documento fiscal deve ter no mínimo 1 dígito e no máximo 2.')]
    #[Format\Text(2)]
    protected string $serie;

    #[Assert\Regex('/^.{1,2}$/', message: 'A subsérie do documento fiscal deve ter no mínimo 1 dígito e no máximo 2.')]
    #[Format\Text(2)]
    protected ?string $subserie;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,10}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 10.')]
    #[Format\Number(10)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'O CFOP é obrigatório.')]
    #[Assert\Regex('/^[1,2,3,5,6,7]{1}[0-9]{3}$/', message: 'CFOP inválido.')]
    protected string $cfop;

    #[Assert\NotBlank(message: 'O tipo de receita é obrigatório.')]
    #[Assert\Choice(choices: ['1', '2', '3'], message: 'Tipo de receita inválido.')]
    protected string $tipoReceita;

    #[Assert\NotBlank(message: 'A ordem do item na nota é obrigatória.')]
    #[Assert\Positive(message: 'A ordem do item deve ser maior que 0.')]
    #[Format\Number(3)]
    protected string $numeroItem;

    #[Assert\NotBlank(message: 'O código do serviço é obrigatório.')]
    #[Format\Text(11)]
    protected string $codigoServico;

    #[Assert\NotBlank(message: 'A quantidade do serviço é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade do serviço não pode ser negativa.')]
    #[Format\Number(13, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor bruto do serviço é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor bruto do serviço não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorServico;

    #[Assert\NotBlank(message: 'O valor de outras despesas é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor de outras despesas não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $outrasDespesas;

    #[Assert\NotBlank(message: 'A base de cálculo de retenção do ICMS é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo de retenção do ICMS não pode ser negativa.')]
    #[Format\Number(12, 2)]
    protected string $baseRetencao;

    #[Assert\NotBlank(message: 'A alíquota é obrigatória.')]
    #[Format\Number(2)]
    protected string $aliquota;

    #[Assert\NotBlank(message: 'O CNPJ / MF da operadora de destino é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpjMF;

    #[Format\Number(10)]
    protected ?string $terminal;

    /**
     * @param string $cnpj CNPJ/CPF do tomador do serviço
     * @param string $codigoModelo Modelo da nota fiscal
     * @param int $serie Série do documento fiscal
     * @param int $numeroDocumento Número do documento fiscal
     * @param string $cfop Código Fiscal de Operação e Prestação
     * @param int $tipoReceita Tipo de receita
     * @param int $numeroItem Número de ordem do item na nota fiscal
     * @param string $codigoServico Código do serviço do informante
     * @param float $quantidade Quantidade do produto (com 3 decimais)
     * @param float $valorServico Valor bruto do serviço (valor unitário multiplicado por quantidade) - com 2 decimais
     * @param float $outrasDespesas Valor do Desconto Concedido no item (com 2 decimais).
     * @param float $baseRetencao Base de Cálculo do ICMS (com 2 decimais)
     * @param int $aliquota Alíquota do ICMS (valor inteiro)
     * @param string $cnpjMF CNPJ/MF da operadora de destino
     * @param string|null $subserie Série do documento fiscal
     * @param int|null $terminal Código que designa o usuário final na rede do informante
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        string $codigoModelo,
        int $serie,
        int $numeroDocumento,
        string $cfop,
        int $tipoReceita,
        int $numeroItem,
        string $codigoServico,
        float $quantidade,
        float $valorServico,
        float $outrasDespesas,
        float $baseRetencao,
        int $aliquota,
        string $cnpjMF,
        ?string $subserie = null,
        ?int $terminal = null,
    ) {
        parent::__construct(Records::REGISTRO_77);

        $this->cnpj = $cnpj;
        $this->codigoModelo = $codigoModelo;
        $this->serie = (string) $serie;
        $this->subserie = $subserie;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->cfop = $cfop;
        $this->tipoReceita = (string) $tipoReceita;
        $this->numeroItem = (string) $numeroItem;
        $this->codigoServico = (string) $codigoServico;
        $this->quantidade = (string) $quantidade;
        $this->valorServico = (string) $valorServico;
        $this->outrasDespesas = (string) $outrasDespesas;
        $this->baseRetencao = (string) $baseRetencao;
        $this->aliquota = (string) $aliquota;
        $this->cnpjMF = $cnpjMF;
        $this->terminal = (string) $terminal;

        $this->validate();
        $this->format();
    }
}
