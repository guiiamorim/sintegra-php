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
 * Analítico - Identificador de cada situação tributária no final do dia de
 * cada equipamento emissor de cupom fiscal
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z60A extends ElementBase
{
    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

    #[Assert\NotBlank(message: 'O número de fabricação do equipamento é obrigatória.')]
    #[Format\Text(20)]
    protected string $numeroFabricacao;

    #[Assert\NotBlank(message: 'A alíquota é obrigatória.')]
    #[Format\Number(4, 2)]
    protected string $aliquota;

    #[Assert\NotBlank(message: 'O valor acumulado é obrigatório.')]
    #[Format\Number(12, 2)]
    protected string $valorTotal;

    #[Format\Text(79)]
    protected ?string $brancos = null;

    /**
     * Constructor
     *
     * @param DateTime $dataEmissao Data de emissão dos documentos fiscais
     * @param string $numeroFabricacao Número de série de fabricação do equipamento
     * @param float $aliquota Valor acumulado no Totalizador Geral (com 2 decimais)
     * @param float $valorTotal Valor acumulado no final do dia no totalizador parcial da situação tributária / alíquota
     * indicada no campo 05 (com 2 decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataEmissao,
        string $numeroFabricacao,
        float $aliquota,
        float $valorTotal,
    ) {
        parent::__construct(Records::REGISTRO_60, subtipo: 'A');

        $this->dataEmissao = $dataEmissao;
        $this->numeroFabricacao = $numeroFabricacao;
        $this->aliquota = (string) $aliquota;
        $this->valorTotal = (string) $valorTotal;

        $this->validate();
        $this->format();
    }
}
