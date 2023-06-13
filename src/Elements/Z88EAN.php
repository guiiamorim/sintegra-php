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
 * REGISTRO "88EAN" - Informação do número do código de barras do produto
 *
 * @see http://www.fazenda.mg.gov.br/empresas/legislacao_tributaria/ricms_2002_seco/anexovii2002_6.html
 */

use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z88EAN extends ElementBase
{
    #[Assert\NotBlank(message: 'A versão do código EAN é obrigatória.')]
    #[Assert\Choice(choices: ['8', '12', '13', '14'], message: 'Versão EAN inválida.')]
    #[Format\Text(2)]
    protected string $versaoEan;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A descrição do produto é obrigatória.')]
    #[Format\Text(53)]
    protected string $descricao;

    #[Assert\NotBlank(message: 'A unidade do produto é obrigatória.')]
    #[Format\Text(6)]
    protected string $unidade;

    #[Assert\NotBlank(message: 'O código de barras é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoBarras;

    #[Format\Text(32)]
    protected ?string $brancos = null;

    /**
     * @param int $versaoEan Versão do código EAN (08, 12, 13 ou 14)
     * @param string $codigoProduto Código do produto ou serviço utilizado pelo contribuinte
     * @param string $descricao Descrição do produto ou serviço
     * @param string $unidade Unidade de medida de comercialização do produto (un, kg, mt, m3, sc, frd, kWh, etc..)
     * @param string $codigoBarras Código de Barra EAN
     *
     * @throws ElementValidation
     */
    public function __construct(
        int $versaoEan,
        string $codigoProduto,
        string $descricao,
        string $unidade,
        string $codigoBarras,
    ) {
        parent::__construct(Records::REGISTRO_88, subtipo: 'EAN');

        $this->versaoEan = (string) $versaoEan;
        $this->codigoProduto = $codigoProduto;
        $this->descricao = $descricao;
        $this->unidade = $unidade;
        $this->codigoBarras = $codigoBarras;

        $this->validate();
        $this->format();
    }

    #[Validate\Gtin(path: 'codigoBarras')]
    public function getGtin(): string
    {
        return substr($this->codigoBarras, (int) $this->versaoEan * -1);
    }
}
