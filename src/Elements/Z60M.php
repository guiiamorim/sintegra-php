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
 * - Exclusivo para empresas emissoras de Cupom Fiscal
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z60M extends ElementBase
{
    #[Assert\NotBlank(message: 'Data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'O número de fabricação do equipamento é obrigatória.')]
    #[Format\Text(20)]
    protected string $numeroFabricacao;

    #[Assert\NotBlank(message: 'O número sequencial do equipamento é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O número sequencial do equipamento deve ser maior ou igual a 0.')]
    #[Format\Number(3)]
    protected string $numeroSequencial;

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

    #[Assert\NotBlank(message: 'O número do documento fiscal inicial é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $inicioContador;

    #[Assert\NotBlank(message: 'O número do documento fiscal final é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $finalContador;

    #[Assert\NotBlank(message: 'O número do CRZ é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do CRZ deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $contadorReducaoZ;

    #[Assert\NotBlank(message: 'O número do CRO é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do CRO deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(3)]
    protected string $contadorReinicioOP;

    #[Assert\NotBlank(message: 'O valor bruto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor bruto não pode ser negativo.')]
    #[Format\Number(16, 2)]
    protected string $valorBruto;

    #[Assert\NotBlank(message: 'O valor geral é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor geral não pode ser negativo.')]
    #[Format\Number(16, 2)]
    protected string $valorGeral;

    #[Format\Text(37)]
    protected ?string $brancos = null;

    /**
     * @param DateTime $dataEmissao Data de emissão dos documentos fiscais
     * @param string $numeroFabricacao Número de série de fabricação do equipamento
     * @param string $numeroSequencial Número atribuído pelo estabelecimento ao equipamento
     * @param string $codigoModelo Código do modelo da nota fiscal
     * @param string $inicioContador Número do primeiro documento fiscal emitido no dia (Número do Contador de Ordem de
     * Operação - COO)
     * @param string $finalContador Número do último documento fiscal emitido no dia (Número do Contador de Ordem de
     * Operação - COO)
     * @param string $contadorReducaoZ Número do Contador de Redução Z (CRZ)
     * @param string $contadorReinicioOP Valor acumulado no Contador de Reinício de Operação (CRO)
     * @param float $valorBruto Valor acumulado no totalizador de Venda Bruta
     * @param float $valorGeral Valor acumulado no Totalizador Geral
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataEmissao,
        string $numeroFabricacao,
        string $numeroSequencial,
        string $codigoModelo,
        string $inicioContador,
        string $finalContador,
        string $contadorReducaoZ,
        string $contadorReinicioOP,
        float $valorBruto,
        float $valorGeral,
    ) {
        parent::__construct(Records::REGISTRO_60, subtipo: 'M');

        $this->dataEmissao = $dataEmissao;
        $this->numeroFabricacao = $numeroFabricacao;
        $this->numeroSequencial = $numeroSequencial;
        $this->codigoModelo = $codigoModelo;
        $this->inicioContador = $inicioContador;
        $this->finalContador = $finalContador;
        $this->contadorReducaoZ = $contadorReducaoZ;
        $this->contadorReinicioOP = $contadorReinicioOP;
        $this->valorBruto = (string) $valorBruto;
        $this->valorGeral = (string) $valorGeral;

        $this->validate();
        $this->format();
    }
}
