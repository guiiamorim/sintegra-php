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
 *  Nota fiscal de serviços de comunicação e telecomunicações
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z76 extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A inscrição estadual não pode ficar em branco, preencha com ISENTO caso o emitente / destinatário não possua.')]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadual;

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

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'A unidade federativa é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $uf;

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
    #[Format\Number(12, 2)]
    protected string $naoTributado;

    #[Assert\NotBlank(message: 'O valor de outras despesas é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor de outras despesas não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $outrasDespesas;

    #[Assert\NotBlank(message: 'A alíquota é obrigatória.')]
    #[Format\Number(2)]
    protected string $aliquota;

    #[Assert\NotBlank(message: 'A situação do documento fiscal é obrigatória.')]
    #[Assert\Choice(choices: ['S', 'N', 'E', 'X', '2', '4'], message: 'Opção inválida para situação do documento.')]
    protected string $situacao;

    /**
     * @param string $cnpj CNPJ/CPF do tomador do serviço
     * @param string $codigoModelo Código do modelo da nota fiscal
     * @param int $serie Série do documento fiscal
     * @param int $numeroDocumento Número do documento fiscal
     * @param int $cfop Código Fiscal de Operação e Prestação
     * @param int $tipoReceita Código da identificação do tipo de receita
     * 1 Receita própria
     * 2 Receita de terceiros
     * 3 Ressarcimento - utilizar este código somente nas hipóteses de estorno de débito do imposto, em que as
     * correspondentes deduções do valor do serviço, da base de cálculo e do respectivo imposto, são lançados no
     * documento fiscal com sinal negativo nos termos do Convênio ICMS 126/98.
     * @param DateTime $dataEmissao Data de emissão na saída ou de recebimento na entrada
     * @param string $uf Sigla da Unidade da Federação do remetente
     * @param float $valorTotal Valor total da nota fiscal (com 2 decimais)
     * @param float $baseRetencao Base de Cálculo do ICMS (com 2 decimais)
     * @param float $valorICMS Montante do imposto (com 2 decimais)
     * @param float $naoTributado Valor amparado por isenção ou não incidência
     * @param float $outrasDespesas Valor que não confira débito ou crédito do ICMS
     * @param int $aliquota Alíquota do ICMS (valor inteiro)
     * @param string $situacao Situação da Nota fiscal
     * N - Documento Fiscal Normal
     * S - Documento Fiscal Cancelado
     * E - Lançamento Extemporâneo de Documento Fiscal Normal
     * X - Lançamento Extemporâneo de Documento Fiscal Cancelado
     * 2 - Documento com USO DENEGADO
     * 4 - Documento com USO inutilizado
     * @param string $inscricaoEstadual Inscrição estadual do tomador do serviço
     * @param string|null $subserie Série do documento fiscal
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        string $codigoModelo,
        int $serie,
        int $numeroDocumento,
        int $cfop,
        int $tipoReceita,
        DateTime $dataEmissao,
        string $uf,
        float $valorTotal,
        float $baseRetencao,
        float $valorICMS,
        float $naoTributado,
        float $outrasDespesas,
        int $aliquota,
        string $situacao,
        string $inscricaoEstadual = 'ISENTO',
        ?string $subserie = null,
    ) {
        parent::__construct(Records::REGISTRO_76);

        $this->cnpj = $cnpj;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->codigoModelo = $codigoModelo;
        $this->serie = (string) $serie;
        $this->subserie = $subserie;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->cfop = (string) $cfop;
        $this->tipoReceita = (string) $tipoReceita;
        $this->dataEmissao = $dataEmissao;
        $this->uf = $uf;
        $this->valorTotal = (string) $valorTotal;
        $this->baseRetencao = (string) $baseRetencao;
        $this->valorICMS = (string) $valorICMS;
        $this->naoTributado = (string) $naoTributado;
        $this->outrasDespesas = (string) $outrasDespesas;
        $this->aliquota = (string) $aliquota;
        $this->situacao = $situacao;

        $this->validate();
        $this->format();
    }
}
