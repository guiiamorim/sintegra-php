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
 * - Exclusivo para empresas emissoras de Cupom Fiscal/ NFCe
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z61 extends ElementBase
{
    #[Format\Text(28)]
    protected ?string $brancos1 = null;

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

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
    #[Assert\Regex('/^\d{1,3}$/', message: 'A série do documento fiscal deve ter no mínimo 1 dígito e no máximo 3.')]
    #[Format\Text(3)]
    protected string $serie;

    #[Assert\Regex('/^\d{1,2}$/', message: 'A subsérie do documento fiscal deve ter no mínimo 1 dígito e no máximo 2.')]
    #[Format\Text(2)]
    protected ?string $subserie;

    #[Assert\NotBlank(message: 'O número do documento fiscal inicial é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroInicial;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroFinal;

    #[Assert\NotBlank(message: 'O valor líquido é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor líquido não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorTotal;

    #[Assert\NotBlank(message: 'A base de cálculo de retenção do ICMS é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo de retenção do ICMS não pode ser negativa.')]
    #[Format\Number(13, 2)]
    protected string $baseRetencao;

    #[Assert\NotBlank(message: 'O valor do ICMS é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do ICMS não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorICMS;

    #[Assert\NotBlank(message: 'O valor não tributado é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor não tributado não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $naoTributado;

    #[Assert\NotBlank(message: 'O valor de outras despesas é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor de outras despesas não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $outrasDespesas;

    #[Assert\NotBlank(message: 'A alíquota é obrigatória.')]
    #[Format\Number(4, 2)]
    protected string $aliquota;

    #[Format\Text(1)]
    protected ?string $brancos2 = null;

    /**
     * @param DateTime $dataEmissao Data de emissão do(s) documento(s) fiscal(is)
     * @param string $codigoModelo Código do modelo da nota fiscal
     * @param string $serie Série do documento fiscal
     * @param int $numeroInicial Número do primeiro documento fiscal emitido no dia do mesmo modelo, série e subsérie
     * @param int $numeroFinal Número do primeiro documento fiscal emitido no dia do mesmo modelo, série e subsérie
     * @param float $valorTotal Valor total do(s) documento(s) fiscal(is)/Movimento diário (com 2 decimais)
     * @param float $baseRetencao Base de cálculo do(s) documento(s) fiscal(is)/Total diário (com 2 decimais)
     * @param float $valorICMS Valor do Montante do Imposto/Total diário (com 2 decimais)
     * @param float $naoTributado Valor amparado por isenção ou não-incidência/Total diário (com 2 decimais)
     * @param float $outrasDespesas Valor que não confira débito ou crédito de ICMS/Total diário (com 2 decimais)
     * @param float $aliquota Alíquota Utilizada no Cálculo do ICMS (com 2 decimais)
     * @param string|null $subserie Subsérie do documento fiscal
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataEmissao,
        string $codigoModelo,
        string $serie,
        int $numeroInicial,
        int $numeroFinal,
        float $valorTotal,
        float $baseRetencao,
        float $valorICMS,
        float $naoTributado,
        float $outrasDespesas,
        float $aliquota,
        ?string $subserie = null,
    ) {
        parent::__construct(Records::REGISTRO_61);

        $this->dataEmissao = $dataEmissao;
        $this->codigoModelo = $codigoModelo;
        $this->serie = $serie;
        $this->subserie = $subserie;
        $this->numeroInicial = (string) $numeroInicial;
        $this->numeroFinal = (string) $numeroFinal;
        $this->valorTotal = (string) $valorTotal;
        $this->baseRetencao = (string) $baseRetencao;
        $this->valorICMS = (string) $valorICMS;
        $this->naoTributado = (string) $naoTributado;
        $this->outrasDespesas = (string) $outrasDespesas;
        $this->aliquota = (string) $aliquota;

        $this->validate();
        $this->format();
    }
}
