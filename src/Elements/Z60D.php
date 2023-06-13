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
 * Resumo Diário - Registro de mercadoria/produto ou serviço constante em
 * documento fiscal emitido por Terminal Ponto de Venda (PDV) ou equipamento
 * Emissor de Cupom Fiscal (ECF)
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z60D extends ElementBase
{
    #[Assert\NotBlank(message: 'Data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'O número de fabricação do equipamento é obrigatória.')]
    #[Format\Text(20)]
    protected string $numeroFabricacao;

    #[Assert\NotBlank(message: 'O código do produto é obrigatória.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade comercializada é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade comercializada não pode ser negativa.')]
    #[Format\Number(13, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor líquido é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor líquido não pode ser negativo.')]
    #[Format\Number(16, 2)]
    protected string $valorProduto;

    #[Assert\NotBlank(message: 'A base de cálculo de retenção do ICMS é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo de retenção do ICMS não pode ser negativa.')]
    #[Format\Number(16, 2)]
    protected string $baseRetencao;

    #[Assert\NotBlank(message: 'A alíquota é obrigatória.')]
    #[Format\Number(4, 2)]
    protected string $aliquota;

    #[Assert\NotBlank(message: 'O valor do ICMS é obrigatório.')]
    #[Format\Number(13, 2)]
    protected string $valorICMS;

    #[Format\Text(19)]
    protected ?string $brancos = null;

    /**
     * Constructor
     *
     * @param DateTime $dataEmissao Data de emissão dos documentos fiscais
     * @param string $numeroFabricacao Número de série de fabricação do equipamento
     * @param string $codigoProduto Código do produto ou serviço do informante
     * @param float $quantidade Quantidade comercializada da mercadoria/produto no dia (com 3 decimais)
     * @param float $valorProduto Valor líquido (valor bruto diminuído dos descontos) da mercadoria/produto acumulado no
     * dia (com 2 decimais)
     * @param float $baseRetencao Base de cálculo do ICMS - valor acumulado no dia (com 2 decimais)
     * @param float $aliquota Identificador da Situação Tributária / Alíquota do ICMS (com 2 decimais)
     * @param float $valorICMS Montante do imposto
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataEmissao,
        string $numeroFabricacao,
        string $codigoProduto,
        float $quantidade,
        float $valorProduto,
        float $baseRetencao,
        float $aliquota,
        float $valorICMS,
    ) {
        parent::__construct(Records::REGISTRO_60, subtipo: 'D');

        $this->dataEmissao = $dataEmissao;
        $this->numeroFabricacao = $numeroFabricacao;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorProduto = (string) $valorProduto;
        $this->baseRetencao = (string) $baseRetencao;
        $this->aliquota = (string) $aliquota;
        $this->valorICMS = (string) $valorICMS;

        $this->validate();
        $this->format();
    }
}
