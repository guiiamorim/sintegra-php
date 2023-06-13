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
 * REGISTRO '88STES' - Informações Referentes a Estoque de Produtos Sujeitos ao
 * Regime de Substituição Tributária ou de Produtos que Tiveram Mudança na
 * Forma de Tributação.
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

final class Z88STES extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A data do inventário é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataInventario;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(60)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade exportada é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade exportada não pode ser negativa.')]
    #[Format\Number(13, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor do ICMS ST é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do ICMS ST não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorIcmsST;

    #[Assert\NotBlank(message: 'O valor do ICMS da operação própria fiscal é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do ICMS da operação própria não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorIcmsOP;

    #[Format\Text(1)]
    protected ?string $brancos = null;

    /**
     * @param string $cnpj CNPJ do informante
     * @param DateTime $dataInventario Data do inventário
     * @param string $codigoProduto Código do produto utilizado pelo informante
     * @param float $quantidade Quantidade do produto (com 3 casas decimais)
     * @param float $valorIcmsST Valor do ICMS ST (com 2 casas decimais)
     * @param float $valorIcmsOP Valor do ICMS da operação própria (com 2 casas decimais)
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        DateTime $dataInventario,
        string $codigoProduto,
        float $quantidade,
        float $valorIcmsST,
        float $valorIcmsOP,
    ) {
        parent::__construct(Records::REGISTRO_88, subtipo: 'STES');

        $this->cnpj = $cnpj;
        $this->dataInventario = $dataInventario;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorIcmsST = (string) $valorIcmsST;
        $this->valorIcmsOP = (string) $valorIcmsOP;

        $this->validate();
        $this->format();
    }
}
