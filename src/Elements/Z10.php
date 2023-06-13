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

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z10 extends ElementBase
{
    #[Assert\NotBlank(message: 'CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(
        message: 'A inscrição estadual não pode ficar em branco, preencha com ISENTO caso o emitente não possua.'
    )]
    #[Assert\Regex('/^[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadual;

    #[Assert\NotBlank(message: 'O nome do contribuinte é obrigatório.')]
    #[Assert\Regex('/^.{2,35}$/', message: 'O nome do contribuinte deve possuir no mínimo duas letras.')]
    #[Format\Text(35)]
    protected string $nomeContribuinte;

    #[Assert\NotBlank(message: 'O município é obrigatório.')]
    #[Assert\Regex('/^.{2,30}$/', message: 'O nome do município deve possuir no mínimo duas letras.')]
    #[Format\Text(30)]
    protected string $municipio;

    #[Assert\NotBlank(message: 'A unidade federativa é obrigatória.')]
    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'Unidade federativa inválida.'
    )]
    #[Format\Text(2)]
    protected string $uf;

    #[Assert\Regex('/^[0-9]{5,10}$/', message: 'Formato de telefone inválido.')]
    #[Format\Number(10)]
    protected ?string $fax;

    #[Assert\NotBlank(message: 'A data inicial é obrigatória.')]
    #[Validate\ValidDate(message: 'A data inicial deve ser o primeiro dia do mês.')]
    #[Format\Date]
    protected DateTime|string $dataInicial;

    #[Assert\NotBlank(message: 'A data final é obrigatória.')]
    #[Validate\ValidDate(Validate\ValidDate::LAST_DAY, message: 'A data final deve ser o último dia do mês.')]
    #[Format\Date]
    protected DateTime|string $dataFinal;

    #[Assert\NotBlank(message: 'O código de identificação do convênio é obrigatório.')]
    #[Assert\Regex('/^1|2|3$/', message: 'Código de identificação do convênio inválido.')]
    protected int $codigoConvenio;

    #[Assert\NotBlank(message: 'O código de identificação da natureza das operações é obrigatório.')]
    #[Assert\Regex('/^1|2|3$/', message: 'Código de identificação da natureza inválido.')]
    protected int $codigoNatureza;

    #[Assert\NotBlank(message: 'O código da finalidade do arquivo é obrigatório.')]
    #[Assert\Regex('/^1|2|3|5$/', message: 'Código da finalidade inválido.')]
    protected int $codigoFinalidade;

    /**
     * Constructor
     *
     * @param string $cnpj Número de inscrição do estabelecimento matriz da pessoa jurídica no CNPJ ou CPF.
     * @param string $nomeContribuinte Nome comercial (razao social).
     * @param string $municipio Municipio do estabelecimentoNome comercial (razao social).
     * @param string $uf Sigla da Unidade da Federação da pessoa.
     * @param DateTime $dataInicial Data inicial das informações contidas no arquivo.
     * @param DateTime $dataFinal Data final das informações contidas no arquivo.
     * @param int $codigoConvenio Código da identificação da estrutura do arquivo magnético entregue.
     * 1 - Estrutura conforme Convênio ICMS 57/95, na versão estabelecida pelo Convênio ICMS 31/99 e com as alterações promovidas até o Convênio ICMS 30/02.
     * 2 - Estrutura conforme Convênio ICMS 57/95, na versão estabelecida pelo Convênio ICMS 69/02 e com as alterações promovidas pelo Convênio ICMS 142/02.
     * 3 - Estrutura conforme Convênio ICMS 57/95, com as alterações promovidas pelo Convênio ICMS 76/03.
     * @param int $codigoNatureza Código da identificação da natureza das operações informadas.
     * 1 - Interestaduais somente operações sujeitas ao regime de substituição tributária
     * 2 - Interestaduais - operações com ou sem substituição tributária
     * 3 - Totalidade das operações do informantes
     * @param int $codigoFinalidade Código da finalidade do arquivo magnético.
     * 1 - Normal
     * 2 - Retificação total de arquivo: substituição total de informações prestadas pelo contribuinte referentes a
     * este período
     * 3 - Retificação aditiva de arquivo: acréscimo de informação não incluída em arquivos já apresentados
     * 5 - Desfazimento: arquivo de informação referente a operações/prestações não efetivadas . Neste caso, o arquivo
     * deverá conter, além dos registros tipo 10 e tipo 90, apenas os registros referentes as operações/prestações não
     * efetivadas
     * @param string $inscricaoEstadual Número de inscrição estadual.
     * @param string|null $fax Telefone do estabelicimento.
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        string $inscricaoEstadual,
        string $nomeContribuinte,
        string $municipio,
        string $uf,
        DateTime $dataInicial,
        DateTime $dataFinal,
        int $codigoConvenio,
        int $codigoNatureza,
        int $codigoFinalidade,
        ?string $fax = null,
    ) {
        parent::__construct(Records::REGISTRO_10);
        $this->cnpj = $cnpj;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->nomeContribuinte = $nomeContribuinte;
        $this->municipio = $municipio;
        $this->uf = $uf;
        $this->fax = $fax;
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
        $this->codigoConvenio = $codigoConvenio;
        $this->codigoNatureza = $codigoNatureza;
        $this->codigoFinalidade = $codigoFinalidade;

        $this->validate();
        $this->format();
    }

    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    public function getInscricaoEstadual(): string
    {
        return $this->inscricaoEstadual;
    }
}
