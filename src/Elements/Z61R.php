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
 * Resumo mensal - Registro de mercadoria/produto ou serviço comercializados
 * através de Nota Fiscal de Produtor ou Nota Fiscal de Venda a Consumidor
 * não emitida por ECF.
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z61R extends ElementBase
{
    #[Assert\NotBlank(message: 'O período de emissão é obrigatório.')]
    #[Format\Date('mY')]
    protected DateTime|string $periodoEmissao;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
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

    #[Format\Text(54)]
    protected ?string $brancos = null;

    /**
     * @param DateTime $periodoEmissao Mês e Ano de emissão dos documentos fiscais
     * @param string $codigoProduto Código do produto do informante
     * @param float $quantidade Quantidade do produto acumulada vendida no mês (com 3 decimais)
     * @param float $valorProduto Valor bruto do produto - valor acumulado da venda do produto no mês (com 2 decimais)
     * @param float $baseRetencao Base de cálculo do ICMS do valor acumulado no mês (com 2 decimais)
     * @param float $aliquota Alíquota Utilizada no Cálculo do ICMS (com 2 decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $periodoEmissao,
        string $codigoProduto,
        float $quantidade,
        float $valorProduto,
        float $baseRetencao,
        float $aliquota,
    ) {
        parent::__construct(Records::REGISTRO_61, subtipo: 'R');

        $this->periodoEmissao = $periodoEmissao;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorProduto = (string) $valorProduto;
        $this->baseRetencao = (string) $baseRetencao;
        $this->aliquota = (string) $aliquota;

        $this->validate();
        $this->format();
    }
}
