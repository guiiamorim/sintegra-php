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
 * Informações de exportações
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z86 extends ElementBase
{
    #[Assert\NotBlank(message: 'O número do registro de exportação é obrigatório.')]
    #[Assert\Regex(
        '/^\d{1,12}$/',
        message: 'O número do registro de exportação deve ter no mínimo 1 dígito e no máximo 12.'
    )]
    #[Format\Number(12)]
    protected string $registroExportacao;

    #[Assert\NotBlank(message: 'A data do registro de exportação é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataRegistro;

    #[Assert\NotBlank(message: 'O CNPJ do remetente é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpjRemetente;

    #[Assert\NotBlank(
        message: 'A inscrição estadual do remetente / destinatário não pode ficar em branco, preencha com ISENTO caso não possua.'
    )]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadualRemetente;

    #[Assert\NotBlank(message: 'A unidade federativa é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $uf;

    #[Assert\NotBlank(message: 'O número do documento fiscal é obrigatório.')]
    #[Assert\Regex('/^\d{1,6}$/', message: 'O número do documento fiscal deve ter no mínimo 1 dígito e no máximo 6.')]
    #[Format\Number(6)]
    protected string $numeroDocumento;

    #[Assert\NotBlank(message: 'A data de emissão é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataEmissao;

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

    #[Assert\NotBlank(message: 'O código do produto é obrigatório.')]
    #[Format\Text(14)]
    protected string $codigoProduto;

    #[Assert\NotBlank(message: 'A quantidade exportada é obrigatória.')]
    #[Assert\PositiveOrZero(message: 'A quantidade exportada não pode ser negativa.')]
    #[Format\Number(11, 3)]
    protected string $quantidade;

    #[Assert\NotBlank(message: 'O valor unitário do produto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor unitário do produto não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorUnitario;

    #[Assert\NotBlank(message: 'O valor total do produto é obrigatório.')]
    #[Assert\PositiveOrZero(message: 'O valor total do produto não pode ser negativo.')]
    #[Format\Number(12, 2)]
    protected string $valorProduto;

    #[Assert\NotBlank(message: 'O código de relacionamento é obrigatório.')]
    #[Assert\Choice(choices: ['0', '1', '2', '3'], message: 'Código de relacionamento inválido.')]
    protected string $relacionamento;

    #[Format\Text(5)]
    protected ?string $brancos = null;

    /**
     * @param int $registroExportacao Nº do registro de Exportação
     * @param DateTime $dataRegistro Data do Registro de Exportação
     * @param string $cnpjRemetente CNPJ do contribuinte Produtor/Industrial/Fabricante que promoveu a remessa com fim
     * específico
     * @param string $uf Unidade da Federação do Produtor/Industrial/Fabricante que promoveu remessa com fim específico
     * @param int $numeroDocumento Nº da Nota Fiscal de remessa com fim específico de exportação recebida
     * @param DateTime $dataEmissao Data de emissão da Nota Fiscal da remessa com fim específico
     * @param string $codigoModelo Código do modelo do documento fiscal
     * @param int $serie Série da Nota Fiscal
     * @param string $codigoProduto Código do produto adotado no registro tipo 75 quando do registro de entrada da
     * Nota Fiscal de remessa com fim específico
     * @param float $quantidade Quantidade, efetivamente exportada, do produto declarado na Nota Fiscal de remessa com
     * fim específico recebida (com três decimais)
     * @param float $valorUnitario Valor unitário do produto (com duas decimais)
     * @param float $valorProduto Valor total do produto (valor unitário multiplicado pela quantidade) - com 2 decimais
     * @param int $relacionamento Preencher conforme tabela de códigos de relacionamento entre Registro de Exportação e
     * Nota Fiscal de remessa com fim específico
     * 0 - Código destinado a especificar a existência de relacionamento de um Registro de Exportação com uma NF de
     * remessa com fim específico (1:1).
     * 1 - Código destinado a especificar a existência de relacionamento de um Registro de Exportação com mais de uma
     * NF de remessa com fim específico (1:N).
     * 2 - Código destinado a especificar a existência de relacionamento de mais de um Registro de Exportação com
     * somente uma NF de remessa com fim específico (N:1).
     * 3 - Código destinado a especificar exportação através da DSE - Declaração Simplificada de Exportação
     * @param string $inscricaoEstadualRemetente Inscrição Estadual do contribuinte Produtor/Industrial/Fabricante que
     * promoveu a remessa com fim específico
     *
     * @throws ElementValidation
     */
    public function __construct(
        int $registroExportacao,
        DateTime $dataRegistro,
        string $cnpjRemetente,
        string $uf,
        int $numeroDocumento,
        DateTime $dataEmissao,
        string $codigoModelo,
        int $serie,
        string $codigoProduto,
        float $quantidade,
        float $valorUnitario,
        float $valorProduto,
        int $relacionamento,
        string $inscricaoEstadualRemetente = 'ISENTO',
    ) {
        parent::__construct(Records::REGISTRO_86);

        $this->registroExportacao = (string) $registroExportacao;
        $this->dataRegistro = $dataRegistro;
        $this->cnpjRemetente = $cnpjRemetente;
        $this->inscricaoEstadualRemetente = $inscricaoEstadualRemetente;
        $this->uf = $uf;
        $this->numeroDocumento = (string) $numeroDocumento;
        $this->dataEmissao = $dataEmissao;
        $this->codigoModelo = $codigoModelo;
        $this->serie = (string) $serie;
        $this->codigoProduto = $codigoProduto;
        $this->quantidade = (string) $quantidade;
        $this->valorUnitario = (string) $valorUnitario;
        $this->valorProduto = (string) $valorProduto;
        $this->relacionamento = (string) $relacionamento;

        $this->validate();
        $this->format();
    }
}
