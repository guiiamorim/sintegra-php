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
 * Informações de exportações
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z85 extends ElementBase
{
    #[Assert\NotBlank(message: 'O número da declaração de exportação é obrigatório.')]
    #[Assert\Regex(
        '/^\d{1,11}$/',
        message: 'O número da declaração de exportação deve ter no mínimo 1 dígito e no máximo 11.'
    )]
    #[Format\Number(11)]
    protected string $numeroDeclaracao;

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'O código de identificação da natureza da exportação é obrigatório.')]
    #[Assert\Choice(choices: ['1', '2', '3', '4'], message: 'Código de identificação da natureza inválido.')]
    protected string $codigoNatureza;

    #[Assert\NotBlank(message: 'O número do registro de exportação é obrigatório.')]
    #[Assert\Regex(
        '/^\d{1,12}$/',
        message: 'O número do registro de exportação deve ter no mínimo 1 dígito e no máximo 12.'
    )]
    #[Format\Number(12)]
    protected string $registroExportacao;

    #[Assert\NotBlank(message: 'A data do registro de exportação é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataRegistro;

    #[Assert\NotBlank(message: 'O número do conhecimento de embarque é obrigatório. Preencha com "PROPRIO" caso não haja conhecimento de embarque.')]
    #[Assert\Regex(
        '/^PROPRIO|.{1,16}$/',
        message: 'O número do conhecimento de embarque deve ter no mínimo 1 dígito e no máximo 16.'
    )]
    #[Format\Text(16)]
    protected string $numeroEmbarque;

    #[Assert\NotBlank(message: 'A data do conhecimento de embarque é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmbarque;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Choice(
        choices: [
            '01', // AWB
            '02', // MAWB
            '03', // HAWB
            '04', // COMAT
            '06', // R. EXPRESSAS
            '07', // ETIQ. REXPRESSAS
            '08', // HR. EXPRESSAS
            '09', // AV7
            '10', // BL
            '11', // MBL
            '12', // HBL
            '13', // CRT
            '14', // DSIC
            '16', // COMAT BL
            '17', // RWB
            '18', // HRWB
            '19', // TIF/DTA
            '20', // CP2
            '91', // NÂO IATA
            '92', // MNAO IATA
            '93', // HNAO IATA
            '99', // OUTROS
        ],
        message: 'Tipo de conhecimento inválido.',
    )]
    protected string $tipoConhecimento;

    #[Assert\NotBlank(message: 'O código do país de destino é obrigatório.')]
    #[Assert\Positive(message: 'Código do país inválido.')]
    #[Format\Number(4)]
    protected string $codigoPais;

    #[Format\Number(8)]
    protected ?string $reservado = null;

    #[Assert\NotBlank(message: 'O número do comprovante de exportação é obrigatório.')]
    #[Assert\Regex(
        '/^\d{1,8}$/',
        message: 'O número do comprovante de exportação deve ter no mínimo 1 dígito e no máximo 8.'
    )]
    #[Format\Text(8)]
    protected string $comprovanteExportacao;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'A data de emissão da nota fiscal é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissaoNF;

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

    #[Format\Text(19)]
    protected ?string $brancos = null;

    /**
     * @param string $numeroDeclaracao N.º da declaração de exportação
     * @param DateTime $dataEmissao Data da declaração
     * @param int $codigoNatureza Natureza da Exportação (1 – Exportação direta; 2 – Exportação indireta)
     * @param int $registroExportacao N.º do registro de Exportação
     * @param DateTime $dataRegistro Data do Registro de Exportação
     * @param int $numeroEmbarque N.º do conhecimento de embarque
     * @param DateTime $dataEmbarque Data do conhecimento de embarque
     * @param string $tipoConhecimento Informação do tipo de conhecimento de transporte (Preencher conforme tabela de
     * tipo de documento de carga do SISCOMEX)
     * 01 AWB
     * 02 MAWB
     * 03 HAWB
     * 04 COMAT
     * 06 R. EXPRESSAS
     * 07 ETIQ. REXPRESSAS
     * 08 HR. EXPRESSAS
     * 09 AV7
     * 10 BL
     * 11 MBL
     * 12 HBL
     * 13 CRT
     * 14 DSIC
     * 16 COMAT BL
     * 17 RWB
     * 18 HRWB
     * 19 TIF/DTA
     * 20 CP2
     * 91 NÂO IATA
     * 92 MNAO IATA
     * 93 HNAO IATA
     * 99 OUTROS
     * @param int $codigoPais Código do país de destino da mercadoria
     * @param int $comprovanteExportacao Número do Comprovante de Exportação
     * @param int $numeroDocumento Número de nota scal de exportação emitida pelo exportador
     * @param DateTime $dataEmissaoNF Data da emissão da NF de exportação / revenda
     * @param string $codigoModelo Código do modelo da nota fiscal
     * @param int $serie Série do documento fiscal
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $numeroDeclaracao,
        DateTime $dataEmissao,
        int $codigoNatureza,
        int $registroExportacao,
        DateTime $dataRegistro,
        int $numeroEmbarque,
        DateTime $dataEmbarque,
        string $tipoConhecimento,
        int $codigoPais,
        int $comprovanteExportacao,
        int $numeroDocumento,
        DateTime $dataEmissaoNF,
        string $codigoModelo,
        int $serie,
    ) {
        parent::__construct(Records::REGISTRO_85);

        $this->numeroDeclaracao = $numeroDeclaracao;
        $this->dataEmissao = $dataEmissao;
        $this->codigoNatureza = (string) $codigoNatureza;
        $this->registroExportacao = (string) $registroExportacao;
        $this->dataRegistro = $dataRegistro;
        $this->numeroEmbarque = (string) $numeroEmbarque;
        $this->dataEmbarque = $dataEmbarque;
        $this->tipoConhecimento = $tipoConhecimento;
        $this->codigoPais = (string) $codigoPais;
        $this->comprovanteExportacao = (string) $comprovanteExportacao;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->dataEmissaoNF = $dataEmissaoNF;
        $this->codigoModelo = $codigoModelo;
        $this->serie = (string) $serie;

        $this->validate();
        $this->format();
    }
}
