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
 * REGISTRO '88STITNF' - Informações sobre Itens das Notas Fiscais Relativas
 * à Entrada de Produtos Sujeitos ao Regime de Substituição Tributária.
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

final class Z88STITNF extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

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
    #[Assert\Regex('/^\d{1,3}$/', message: 'A série do documento fiscal deve ter no mínimo 1 dígito e no máximo 3.')]
    #[Format\Text(3)]
    protected string $serie;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,9}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 9.')]
    #[Format\Number(9)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'O CFOP é obrigatório.')]
    #[Assert\Regex('/^[1,2,3,5,6,7]{1}[0-9]{3}$/', message: 'CFOP inválido.')]
    protected string $cfop;

    #[Assert\NotBlank(message: 'O Código da Situação Tributária é obrigatório.')]
    #[Assert\Regex('/^.{1,3}$/', message: 'CST inválido.')]
    #[Format\Number(3)]
    protected string $cst;

    #[Assert\NotBlank(message: 'A ordem do item na nota é obrigatória.')]
    #[Assert\Positive(message: 'A ordem do item deve ser maior que 0.')]
    #[Format\Number(3)]
    protected string $numeroItem;

    #[Assert\NotBlank(message: 'A data da entrada é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEntrada;

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(60)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade exportada é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade exportada não pode ser negativa.')]
    #[Format\Number(11, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor total do produto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor total do produto não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorProduto;

    #[Assert\NotBlank(message: 'O desconto do produto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O desconto do produto deve ser igual ou superior a 0.')]
    #[Format\Number(12, 2)]
    protected string $desconto;

    #[Assert\NotBlank(message: 'A base de cálculo do ICMS da operação própria é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo do ICMS da operação própria não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $baseIcmsOP;

    #[Assert\NotBlank(message: 'A base de cálculo do ICMS da substituição tributária é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A base de cálculo do ICMS da substituição tributária não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $baseIcmsST;

    #[Assert\NotBlank(message: 'O valor da alíquota da substituição tributária é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor da alíquota da substituição tributária não pode ser negativo.')]
    #[Format\Number(4, 2)]
    protected string $aliquotaST;

    #[Assert\NotBlank(message: 'O valor da alíquota da operação própria é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor da alíquota da operação própria não pode ser negativo.')]
    #[Format\Number(4, 2)]
    protected string $aliquotaOP;

    #[Assert\NotBlank(message: 'O valor do IPI é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor do IPI não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorIpi;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,44}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 44.')]
    #[Format\Number(44)]
    protected string $chaveNfe;

    /**
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        string $codigoModelo,
        int $serie,
        int $numeroDocumento,
        int $cfop,
        int $cst,
        int $numeroItem,
        DateTime $dataEntrada,
        string $codigoProduto,
        float $quantidade,
        float $valorProduto,
        float $desconto,
        float $baseIcmsOP,
        float $baseIcmsST,
        float $aliquotaST,
        float $aliquotaOP,
        float $valorIpi,
        int $chaveNfe,
    ) {
        parent::__construct(Records::REGISTRO_88, 237, 'STITNF');

        $this->cnpj = $cnpj;
        $this->codigoModelo = $codigoModelo;
        $this->serie = (string) $serie;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->cfop = (string) $cfop;
        $this->cst = (string) $cst;
        $this->numeroItem = (string) $numeroItem;
        $this->dataEntrada = $dataEntrada;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorProduto = (string) $valorProduto;
        $this->desconto = (string) $desconto;
        $this->baseIcmsOP = (string) $baseIcmsOP;
        $this->baseIcmsST = (string) $baseIcmsST;
        $this->aliquotaST = (string) $aliquotaST;
        $this->aliquotaOP = (string) $aliquotaOP;
        $this->valorIpi = (string) $valorIpi;
        $this->chaveNfe = (string) $chaveNfe;

        $this->validate();
        $this->format();
    }
}
