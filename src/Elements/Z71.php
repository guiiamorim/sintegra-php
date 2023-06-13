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
 *  Informações da carga transportada
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z71 extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ do tomador é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpjTomador;

    #[Assert\NotBlank(message: 'A inscrição estadual do tomador não pode ficar em branco, preencha com ISENTO caso o tomador não possua.')]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadualTomador;

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissaoConhecimento;

    #[Assert\NotBlank(message: 'A unidade federativa do tomador é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $ufTomador;

    #[Assert\NotBlank(message: 'O modelo da nota de conhecimento é obrigatório.')]
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
        message: 'Modelo da nota de conhecimento inválido.',
    )]
    protected string $modeloConhecimento;

    #[Assert\NotBlank(message: 'A série do documento de conhecimento é obrigatória.')]
    #[Assert\Regex('/^\d{1}$/', message: 'A série do documento de conhecimento deve ter somente 1 dígito.')]
    protected string $serieConhecimento;

    #[Assert\Regex(
        '/^.{1,2}$/',
        message: 'A subsérie do documento de conhecimento deve ter no mínimo 1 dígito e no máximo 2.'
    )]
    #[Format\Text(2)]
    protected ?string $subserieConhecimento;

    #[Assert\NotBlank(message: 'O número do documento de conhecimento é obrigatório.')]
    #[Assert\Regex(
        '/^\d{1,6}$/',
        message: 'O número do documento de conhecimento deve ter no mínimo 1 dígito e no máximo 6.'
    )]
    #[Format\Number(6)]
    protected string $numeroConhecimento;

    #[Assert\NotBlank(message: 'A unidade federativa do remetente / destinatário é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $ufRemetente;

    #[Assert\NotBlank(message: 'O CPF / CNPJ do remetente / destinatário é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpjRemetente;

    #[Assert\NotBlank(
        message: 'A inscrição estadual do remetente / destinatário não pode ficar em branco, preencha com ISENTO caso não possua.'
    )]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadualRemetente;

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
    protected string $modeloNF;

    #[Assert\NotBlank(message: 'A série do documento fiscal é obrigatória.')]
    #[Assert\Regex('/^\d{1,3}$/', message: 'A série do documento fiscal deve ter no mínimo 1 dígito e no máximo 3.')]
    #[Format\Text(3)]
    protected string $serieNF;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroNF;

    #[Assert\NotBlank(message: 'O valor total do documento fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do documento não pode ser negativo.')]
    #[Format\Number(14, 2)]
    protected string $valorTotal;

    #[Format\Text(12)]
    protected ?string $brancos = null;

    /**
     * @param string $cnpjTomador CNPJ do tomador do serviço
     * @param DateTime $dataEmissaoConhecimento Data de emissão do conhecimento
     * @param string $ufTomador Sigla da Unidade da Federação do tomador
     * @param string $modeloConhecimento Código do modelo da nota fiscal
     * @param int $serieConhecimento Série do conhecimento
     * @param int $numeroConhecimento Número do conhecimento
     * @param string $ufRemetente Unidade da Federação do remetente/destinatário da nota scal
     * @param string $cnpjRemetente CNPJ do remetente/destinatário da nota scal
     * @param DateTime $dataEmissaoNF Data de emissão da nota scal que acoberta a carga transportada
     * @param string $modeloNF Código do modelo da nota fiscal
     * @param int $serieNF Série da nota fiscal
     * @param int $numeroNF Número da nota fiscal
     * @param float $valorTotal Valor total da nota fiscal (com 2 decimais)
     * @param string $inscricaoEstadualTomador Inscrição estadual do tomador do serviço
     * @param string $inscricaoEstadualRemetente Inscrição estadual do remetente/destinatário da nota fiscal
     * @param string|null $subserieConhecimento Sub-Série do conhecimento
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpjTomador,
        DateTime $dataEmissaoConhecimento,
        string $ufTomador,
        string $modeloConhecimento,
        int $serieConhecimento,
        int $numeroConhecimento,
        string $ufRemetente,
        string $cnpjRemetente,
        DateTime $dataEmissaoNF,
        string $modeloNF,
        int $serieNF,
        int $numeroNF,
        float $valorTotal,
        string $inscricaoEstadualTomador = 'ISENTO',
        string $inscricaoEstadualRemetente = 'ISENTO',
        ?string $subserieConhecimento = null,
    ) {
        parent::__construct(Records::REGISTRO_71);

        $this->cnpjTomador = $cnpjTomador;
        $this->inscricaoEstadualTomador = $inscricaoEstadualTomador;
        $this->dataEmissaoConhecimento = $dataEmissaoConhecimento;
        $this->ufTomador = $ufTomador;
        $this->modeloConhecimento = $modeloConhecimento;
        $this->serieConhecimento = (string) $serieConhecimento;
        $this->subserieConhecimento = $subserieConhecimento;
        $this->numeroConhecimento = (string) $numeroConhecimento;
        $this->ufRemetente = $ufRemetente;
        $this->cnpjRemetente = $cnpjRemetente;
        $this->inscricaoEstadualRemetente = $inscricaoEstadualRemetente;
        $this->dataEmissaoNF = $dataEmissaoNF;
        $this->modeloNF = $modeloNF;
        $this->serieNF = (string) $serieNF;
        $this->numeroNF = (string) $numeroNF;
        $this->valorTotal = (string) $valorTotal;

        $this->validate();
        $this->format();
    }
}
