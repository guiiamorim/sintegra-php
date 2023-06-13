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
 * Total de nota fiscal quanto ao IPI
 *
 * Os registros tipo 51 deverão ser gerados somente por contribuintes de IPI.
 * Os contribuintes exclusivamente de ICMS não deverão informar registros tipo 51, ainda que
 *  tenham recebido mercadorias sujeitas ao IPI.
 * Só deverão ser informadas no registro tipo 51 operações acobertadas por notas fiscais
 * modelo 1 ou 1A (código de modelo = 01 no tipo 50), não devendo ser informadas
 * operações acobertadas por outros modelos de documentos fiscais (principalmente os
 * modelos 06 e 22, que são informados somente no tipo 50). Observar que no lay out do
 * tipo 51 não existe campo para modelo de documento fiscal, sendo que o validador
 * SINTEGRA assume que todos os registros são modelo 01 para comparação das críticas
 * de integridade relacional entre os tipos 50 e 51.
 * Deve haver correspondência com a NF indicada no tipo 50 correspondente, conter os
 * mesmos, CGC, número da nota, CFOP, data de emissão da nota, série da nota, valor
 * total e a mesma situação.
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z51 extends ElementBase
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

    #[Assert\NotBlank(message: 'O valor total do documento fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do documento não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorTotal;

    #[Assert\NotBlank(message: 'O valor do ICMS do documento fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do ICMS do documento não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorIpi;

    #[Assert\NotBlank(message: 'O valor de isenção do documento fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor de isenção do documento não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorIsencao;

    #[Format\Number(13, 2)]
    protected string $outrosValores;

    #[Format\Text(20)]
    protected ?string $brancos = null;

    #[Assert\NotBlank(message: 'A situação do documento fiscal é obrigatória.')]
    #[Assert\Choice(choices: ['S', 'N', 'E', 'X', '2', '4'], message: 'Opção inválida para situação do documento.')]
    protected string $situacao;

    /**
     * Constructor
     *
     * @param string $cnpj CNPJ/CPF do remetente nas entradas e dos destinátarios nas saídas
     * @param DateTime $dataEmissao Data de emissão na saída ou de recebimento na entrada
     * @param string $uf Sigla da Unidade da Federação do remetente
     * @param string $serie Série do documento fiscal
     * @param string $numeroDocumento Número do documento fiscal
     * @param string $cfop Código Fiscal de Operação e Prestação
     * @param float $valorTotal Valor total da nota fiscal (com 2 decimais)
     * @param float $valorIpi Montante do IPI (com 2 decimais)
     * @param float $valorIsencao Valor amparado por isenção ou não incidência do IPI (com 2 decimais)
     * @param string $situacao Situação da Nota fiscal
     * N - Documento Fiscal Normal
     * S - Documento Fiscal Cancelado
     * E - Lançamento Extemporâneo de Documento Fiscal Normal
     * X - Lançamento Extemporâneo de Documento Fiscal Cancelado
     * 2 - Documento com USO DENEGADO
     * 4 - Documento com USO inutilizado
     * @param string $inscricaoEstadual Inscrição estadual do remetente nas entradas e do destinatário nas saídas
     * @param float $outrosValores 'Valor que não confira débito ou crédito do ICMS (com 2 decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        DateTime $dataEmissao,
        string $uf,
        string $serie,
        string $numeroDocumento,
        string $cfop,
        float $valorTotal,
        float $valorIpi,
        float $valorIsencao,
        string $situacao,
        string $inscricaoEstadual = 'ISENTO',
        float $outrosValores = 0.00,
    ) {
        parent::__construct(Records::REGISTRO_51);

        $this->cnpj = $cnpj;
        $this->dataEmissao = $dataEmissao;
        $this->uf = $uf;
        $this->serie = $serie;
        $this->numeroDocumento = $numeroDocumento;
        $this->cfop = $cfop;
        $this->valorTotal = (string) $valorTotal;
        $this->valorIpi = (string) $valorIpi;
        $this->valorIsencao = (string) $valorIsencao;
        $this->situacao = $situacao;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->outrosValores = (string) $outrosValores;

        $this->validate();
        $this->format();
    }
}
