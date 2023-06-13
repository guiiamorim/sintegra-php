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
 *  Registro de inventário
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z74 extends ElementBase
{
    #[Assert\NotBlank(message: 'A data do inventário é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataInventario;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade do produto é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade do produto não pode ser negativa.')]
    #[Format\Number(13, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor líquido é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor líquido não pode ser negativo.')]
    #[Format\Number(13, 2)]
    protected string $valorProduto;

    #[Assert\NotBlank(message: 'O código de posse é obrigatório.')]
    #[Assert\Choice(choices: ['1', '2', '3'], message: 'Código de posse inválido.')]
    protected string $codigoPosse;

    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A inscrição estadual não pode ficar em branco, preencha com ISENTO caso o proprietário / possuidor não possua.')]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadual;

    #[Assert\NotBlank(message: 'A unidade federativa é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $uf;

    #[Format\Text(45)]
    protected ?string $brancos = null;

    /**
     * @param DateTime $dataInventario Data do inventário
     * @param string $codigoProduto Código do produto
     * @param float $quantidade Quantidade do produto (com 3 decimais)
     * @param float $valorProduto Valor bruto do produto (valor unitário multiplicado por quantidade) - com 2 decimais
     * @param int $codigoPosse Código de posse das mercadorias inventariadas
     * 1 - Mercadorias de propriedade do Informante e em seu poder
     * 2 - Mercadorias de propriedade do Informante em poder de terceiros
     * 3 - Mercadorias de propriedade de terceiros em poder do Informante
     * @param string $cnpj CNPJ do possuidor/proprietário
     * @param string $uf UF do possuidor/proprietário
     * @param string $inscricaoEstadual Inscrição estadual do possuidor / proprietário
     *
     * @throws ElementValidation
     */
    public function __construct(
        DateTime $dataInventario,
        string $codigoProduto,
        float $quantidade,
        float $valorProduto,
        int $codigoPosse,
        string $cnpj,
        string $uf,
        string $inscricaoEstadual = 'ISENTO',
    ) {
        parent::__construct(Records::REGISTRO_74);

        $this->dataInventario = $dataInventario;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorProduto = (string) $valorProduto;
        $this->codigoPosse = (string) $codigoPosse;
        $this->cnpj = $cnpj;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->uf = $uf;

        $this->validate();
        $this->format();
    }
}
