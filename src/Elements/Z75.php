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
 * Obrigatório para informar as condições do produto/serviço.
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z75 extends ElementBase
{
    #[Assert\NotBlank(message: 'A data inicial é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataInicial;

    #[Assert\NotBlank(message: 'A data final é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataFinal;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'O código NCM é obrigatório.')]
    #[Format\Text(8)]
    protected string $ncm;

    #[Assert\NotBlank(message: 'A descrição do produto é obrigatória.')]
    #[Format\Text(53)]
    protected string $descricao;

    #[Assert\NotBlank(message: 'A unidade do produto é obrigatória.')]
    #[Format\Text(6)]
    protected string $unidade;

    #[Assert\NotBlank(message: 'A alíquota do IPI do documento fiscal é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A alíquota do IPI do documento não pode ser negativa.')]
    #[Format\Number(5, 2)]
    protected string $aliquotaIPI;

    #[Assert\NotBlank(message: 'A alíquota do ICMS do documento fiscal é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A alíquota do ICMS do documento não pode ser negativo.')]
    #[Format\Number(4, 2)]
    protected string $aliquotaICMS;

    #[Assert\NotBlank(message: 'A redução da base de cálculo do ICMS do documento fiscal é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A redução da base de cálculo do ICMS do documento não pode ser negativo.')]
    #[Format\Number(5, 2)]
    protected string $reducaoBaseICMS;

    #[Assert\NotBlank(message: 'A base de cálculo do ICMS do documento fiscal é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo do ICMS do documento não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $baseIcms;

    /**
     * @param DateTime $dataInicial Data inicial das informações contidas no arquivo.
     * @param DateTime $dataFinal Data final das informações contidas no arquivo.
     * @param string $codigoProduto Código do produto ou serviço do informante
     * @param string $ncm Codificação da Nomenclatura Comum do Mercosul
     * @param string $descricao Descrição do produto ou serviço
     * @param string $unidade Unidade de medida de comercialização do produto (un, kg, mt, m3, sc, frd, kWh, etc..)
     * @param float $aliquotaIPI Alíquota do IPI do produto (com 2 decimais)
     * @param float $aliquotaICMS Alíquota do ICMS aplicável a mercadoria ou serviço nas operações
     * @param float $reducaoBaseICMS % de Redução na base de cálculo do ICMS, nas operações internas (com 2 decimais)
     * @param float $baseIcms Base de Cálculo do ICMS de substituição tributária (com 2 decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataInicial,
        DateTime $dataFinal,
        string $codigoProduto,
        string $ncm,
        string $descricao,
        string $unidade,
        float $aliquotaIPI,
        float $aliquotaICMS,
        float $reducaoBaseICMS,
        float $baseIcms,
    ) {
        parent::__construct(Records::REGISTRO_75);

        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
        $this->codigoProduto = $codigoProduto;
        $this->ncm = $ncm;
        $this->descricao = $descricao;
        $this->unidade = $unidade;
        $this->aliquotaIPI = (string) $aliquotaIPI;
        $this->aliquotaICMS = (string) $aliquotaICMS;
        $this->reducaoBaseICMS = (string) $reducaoBaseICMS;
        $this->baseIcms = (string) $baseIcms;

        $this->validate();
        $this->format();
    }
}
