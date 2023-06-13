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
 * Estado de MG
 *
 * REGISTRO "88DV" - Informações sobre itens registrados em Cupom Fiscal
 * relativos à Entrada de Produtos em Devolução ou Troca
 *
 * @see http://www.fazenda.mg.gov.br/empresas/legislacao_tributaria/ricms_2002_seco/anexovii2002_6.html
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z88DV extends ElementBase
{
    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'A série do documento fiscal é obrigatória.')]
    #[Assert\Regex('/^\d{1,3}$/', message: 'A série do documento fiscal deve ter no mínimo 1 dígito e no máximo 3.')]
    #[Format\Text(3)]
    protected string $serie;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroCOO;

    #[Assert\NotBlank(message: 'A data de emissão do cupom fiscal é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissaoCupom;

    #[Assert\NotBlank(message: 'A ordem do item na nota é obrigatória.')]
    #[Assert\Positive(message: 'A ordem do item deve ser maior que 0.')]
    #[Format\Number(3)]
    protected string $numeroItem;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade exportada é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade exportada não pode ser negativa.')]
    #[Format\Number(13, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $relatorioNumeroCOO;

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $relatorioDataEmissao;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(20)]
    protected string $numeroFabricacao;

    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'O valor unitário do produto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor unitário do produto não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorUnitario;

    #[Assert\NotBlank(message: 'A base de cálculo do ICMS do documento fiscal é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo do ICMS do documento não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $baseIcms;

    #[Assert\NotBlank(message: 'O valor do ICMS do documento fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do ICMS do documento não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorIcms;

    /**
     * @param DateTime $dataEmissao Data de emissão da Nota Fiscal global diária
     * @param string $serie Número de Série da Nota Fiscal global diária
     * @param int $numeroDocumento Número da Nota Fiscal global diária
     * @param int $numeroCOO Número do Contador de Ordem de Operação - COO do Cupom Fiscal de venda do produto devolvido
     * ou trocado
     * @param DateTime $dataEmissaoCupom Data de emissão do Cupom Fiscal de venda do produto devolvido ou trocado
     * @param int $numeroItem Número de ordem do item devolvido no Cupom Fiscal de origem
     * @param string $codigoProduto Código do produto devolvido ou trocado
     * @param float $quantidade Quantidade do produto devolvido (com 3 decimais)
     * @param int $relatorioNumeroCOO Número do Contador de Ordem de Operação - COO do Relatório Gerencial de
     * Devolução/Troca
     * @param DateTime $relatorioDataEmissao Data de emissão do Relatório Gerencial de Devolução/Troca
     * @param string $numeroFabricacao Número de série de fabricação do ECF que emitiu o Cupom Fiscal de venda
     * @param string $cnpj Nº do CNPJ/CPF do responsável pela devolução/troca
     * @param float $valorUnitario Valor unitário da mercadoria (com 2 decimais)
     * @param float $baseIcms Base de Cálculo do ICMS (com 2 decimais)
     * @param float $valorIcms Montante do imposto (com 2 decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataEmissao,
        string $serie,
        int $numeroDocumento,
        int $numeroCOO,
        DateTime $dataEmissaoCupom,
        int $numeroItem,
        string $codigoProduto,
        float $quantidade,
        int $relatorioNumeroCOO,
        DateTime $relatorioDataEmissao,
        string $numeroFabricacao,
        string $cnpj,
        float $valorUnitario,
        float $baseIcms,
        float $valorIcms,
    ) {
        parent::__construct(Records::REGISTRO_88, 149, 'DV');

        $this->dataEmissao = $dataEmissao;
        $this->serie = $serie;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->numeroCOO = (string) $numeroCOO;
        $this->dataEmissaoCupom = $dataEmissaoCupom;
        $this->numeroItem = (string) $numeroItem;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->relatorioNumeroCOO = (string) $relatorioNumeroCOO;
        $this->relatorioDataEmissao = $relatorioDataEmissao;
        $this->numeroFabricacao = $numeroFabricacao;
        $this->cnpj = $cnpj;
        $this->valorUnitario = (string) $valorUnitario;
        $this->baseIcms = (string) $baseIcms;
        $this->valorIcms = (string) $valorIcms;

        $this->validate();
        $this->format();
    }
}
