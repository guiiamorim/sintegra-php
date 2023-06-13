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
 * Substituição tributária
 *
 * Os registros tipo 53 só deverão ser gerados por contribuintes substitutos
 * tributários. Substituto tributário é aquele a quem a legislação obriga a, no momento
 * da venda de seu produto, além de pagar o imposto próprio, fazer a retenção do
 * imposto referente às operações seguintes, recolhendo-o em separado daquele
 * referente a suas próprias operações. Ele está obrigado a gerar o registro 50 e o
 * registro 53, referentes a uma mesma operação. Substituído é o comerciante que
 *adquire a mercadoria com o imposto já retido.
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z53 extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A inscrição estadual não pode ficar em branco, preencha com ISENTO caso o emitente / destinatário não possua.')]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadual;

    #[Assert\NotBlank(message: 'A data de emissão / recebimento é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'A unidade federativa é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $uf;

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

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'O CFOP é obrigatório.')]
    #[Assert\Regex('/^[1,2,3,5,6,7]{1}[0-9]{3}$/', message: 'CFOP inválido.')]
    protected string $cfop;

    #[Assert\NotBlank(message: 'A descrição do emitente do documento fiscal é obrigatória.')]
    #[Assert\Choice(
        choices: ['P', 'T'],
        message: 'Opção inválida para emitente do documento fiscal. Preencha com "P" ou "T".'
    )]
    protected string $emitente;

    #[Assert\NotBlank(message: 'A base de cálculo de retenção do ICMS é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo de retenção do ICMS não pode ser negativa.')]
    #[Format\Number(13, 2)]
    protected string $baseRetencao;

    #[Assert\NotBlank(message: 'O valor de retenção do ICMS é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor de retenção do ICMS não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorRetencao;

    #[Assert\NotBlank(message: 'A soma das despesas acessórias é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A soma das despesas acessórias não pode ser negativa.')]
    #[Format\Number(13, 2)]
    protected string $despesas;

    #[Assert\NotBlank(message: 'A situação do documento fiscal é obrigatória.')]
    #[Assert\Choice(choices: ['S', 'N', 'E', 'X', '2', '4'], message: 'Opção inválida para situação do documento.')]
    protected string $situacao;

    #[Assert\Choice(choices: ['1', '2', '3', '4', '5', '6', ''], message: 'Opção inválida para código de antecipação.')]
    #[Format\Text(1)]
    protected string $codigoAntecipacao;

    #[Format\Text(29)]
    protected ?string $brancos = null;

    /**
     * Constructor
     *
     * @param string $cnpj CNPJ/CPF do remetente nas entradas e dos destinátarios nas saídas
     * @param DateTime $dataEmissao Data de emissão na saída ou de recebimento na entrada
     * @param string $uf Sigla da Unidade da Federação do remetente
     * @param string $codigoModelo Código do modelo da nota fiscal
     * 01 - Nota Fiscal, modelo 1
     * 02 - Nota Fiscal de Venda a Consumidor, modelo 02
     * 03 - Nota Fiscal de Entrada, modelo 3
     * 04 - Nota Fiscal de Produtor, modelo 4
     * 06 - Nota Fiscal/Conta de Energia Elétrica, modelo 6
     * 07 - Nota Fiscal de Serviço de Transporte, modelo 7
     * 08 - Conhecimento de Transporte Rodoviário de Cargas, modelo 8
     * 09 - Conhecimento de Transporte Aquaviário de Cargas, modelo 9
     * 10 - Conhecimento Aéreo, modelo 10
     * 11 - Conhecimento de Transporte Ferroviário de Cargas, modelo 11
     * 13 - Bilhete de Passagem Rodoviário, modelo 13
     * 14 - Bilhete de Passagem Aquaviário, modelo 14
     * 15 - Bilhete de Passagem e Nota de Bagagem, modelo 15
     * 16 - Bilhete de Passagem Ferroviário, modelo 16
     * 17 - Despacho de Transporte, modelo 17
     * 18 - Resumo Movimento Diário, modelo 18
     * 20 - Ordem de Coleta de Carga, modelo 20
     * 21 - Nota Fiscal de Serviço de Comunicação, modelo 21
     * 22 - Nota Fiscal de Serviço de Telecomunicações, modelo 22
     * 24 - Autorização de Carregamento e Transporte, modelo 24
     * 25 - Manifesto de Carga, modelo 25
     * 26 - Conhecimento de Transporte Multimodal de Cargas, modelo 26
     * 27 - Nota Fiscal de Serviço de Transporte Ferroviário, modelo 27
     * 55 - Nota Fiscal Eletrônica, modelo 55
     * 57 - Conhecimento de Transporte Eletrônico, modelo 57
     * 60 - Cupom Fiscal Eletrônico, CF-e- ECF, modelo 60
     * 63 - Bilhete de Passagem Eletrônico, modelo 63
     * 65 - Nota Fiscal de Consumidor Eletrônica, modelo 65
     * 66 - Nota Fiscal Energia Eletrica Eletrônica, modelo 66
     * 67 - Conhecimento de Transporte Eletrônico para Outros Serviços, modelo 67
     * @param string $serie Série do documento fiscal
     * @param string $numeroDocumento Número do documento fiscal
     * @param string $cfop Código Fiscal de Operação e Prestação
     * @param string $emitente Emitente da Nota Fiscal (P- próprio/T-terceiros)
     * @param string $baseRetencao Base de cálculo de retenção do ICMS (com 2 decimais)
     * @param string $valorRetencao ICMS retido pelo substituto (com 2 decimais)
     * @param string $despesas Soma das despesas acessórias (frete, seguro e outras - com 2 decimais)
     * @param string $situacao Situação da Nota fiscal
     * N - Documento Fiscal Normal
     * S - Documento Fiscal Cancelado
     * E - Lançamento Extemporâneo de Documento Fiscal Normal
     * X - Lançamento Extemporâneo de Documento Fiscal Cancelado
     * 2 - Documento com USO DENEGADO
     * 4 - Documento com USO inutilizado
     * @param string $codigoAntecipacao Código que identifica o tipo da Antecipação Tributária
     * 1 - Pagamento de substituição efetuada pelo destinatário, quando não efetuada ou efetuada a menor pelo substituto
     * 2 - Antecipação tributária efetuada pelo destinatário apenas com complementação do diferencial de aliquota
     * 3 - Antecipação tributária com MVA (Margem de Valor Agregado), efetuada pelo destinatário sem encerrar a fase de
     * tributação
     * 4 - Antecipação tributária com MVA (Margem de Valor Agregado), efetuada pelo destinatário encerrando a fase de
     * tributação
     * 5 - Substituição tributária interna motivada por regime especial de tributação 5
     * 6 - ICMS pago na importação 6
     * '' - Substituição Tributária informada pelo substituto ou pelo substituído que não incorra em nenhuma das
     * situações anteriores
     * @param string $inscricaoEstadual Inscrição estadual do remetente nas entradas e do destinatário nas saídas
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        DateTime $dataEmissao,
        string $uf,
        string $codigoModelo,
        string $serie,
        string $numeroDocumento,
        string $cfop,
        string $emitente,
        string $baseRetencao,
        string $valorRetencao,
        string $despesas,
        string $situacao,
        string $codigoAntecipacao = '',
        string $inscricaoEstadual = 'ISENTO',
    ) {
        parent::__construct(Records::REGISTRO_53);

        $this->cnpj = $cnpj;
        $this->dataEmissao = $dataEmissao;
        $this->uf = $uf;
        $this->codigoModelo = $codigoModelo;
        $this->serie = $serie;
        $this->numeroDocumento = $numeroDocumento;
        $this->cfop = $cfop;
        $this->emitente = $emitente;
        $this->baseRetencao = $baseRetencao;
        $this->valorRetencao = $valorRetencao;
        $this->despesas = $despesas;
        $this->situacao = $situacao;
        $this->codigoAntecipacao = $codigoAntecipacao;
        $this->inscricaoEstadual = $inscricaoEstadual;

        $this->validate();
        $this->format();
    }
}
