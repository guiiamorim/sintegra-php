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
 * Guia Nacional de Recolhimento de Tributos Estaduais - GNRE
 *
 * Os registros tipo 55 só deverão ser informados por contribuintes substitutos
 * tributários.
 * Deverá ser gerado um registro para cada GNRE RECOLHIDA no período relativo ao
 * arquivo magnético.
 * Deverão ser informadas todas as GNRE recolhidas independentemente da UF
 * favorecida.
 */

use DateTime;
use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z55 extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A inscrição estadual não pode ficar em branco, preencha com ISENTO caso o emitente / destinatário não possua.')]
    #[Assert\Regex('/^ISENTO|[0-9]{0,14}$/', message: 'Formato inválido para a inscrição estadual.')]
    #[Format\Text(14)]
    protected string $inscricaoEstadual;

    #[Assert\NotBlank(message: 'A data de pagamento é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataGnre;

    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'UF do contribuinte substituto inválido.'
    )]
    #[Format\Text(2)]
    protected string $ufSubstituto;

    #[Assert\Regex(
        '/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)$/',
        message: 'UF de destino inválido.'
    )]
    #[Format\Text(2)]
    protected string $ufFavorecido;

    #[Assert\NotBlank(message: 'Código do banco obrigatório.')]
    #[Assert\Positive(message: 'Código do banco inválido.')]
    #[Format\Number(3)]
    protected string $gnreBanco;

    #[Assert\NotBlank(message: 'Agência bancária obrigatória.')]
    #[Assert\Positive(message: 'Agência bancária inválida.')]
    #[Format\Number(4)]
    protected string $gnreAgencia;

    #[Assert\NotBlank(message: 'Número GNRE obrigatório.')]
    #[Format\Text(20)]
    protected string $gnreNumero;

    #[Assert\NotBlank(message: 'Valor total do GNRE obrigatório.')]
    #[Format\Number(13, 2)]
    protected string $valorTotal;

    #[Assert\NotBlank(message: 'A data de vencimento do ICMS é obrigatória.')]
    #[Format\Date]
    protected DateTime|string $dataIcms;

    #[Assert\NotBlank(message: 'O mês e ano da ocorrência é obrigatório.')]
    #[Format\Date('mY')]
    protected DateTime|string $mesAno;

    #[Assert\NotBlank(message: 'Convênio GNRE obrigatório.')]
    #[Format\Text(30)]
    protected string $convenio;

    /**
     * Constructor
     *
     * @param string $cnpj CNPJ do remetente nas entradas e dos destinátarios nas saídas
     * @param DateTime $dataGnre Data do pagamento do documento de arrecadação
     * @param string $ufSubstituto Sigla da unidade da federação do contribuinte substituto tributário
     * @param string $ufFavorecido Sigla da unidade da federação de destino (favorecida)
     * @param int $gnreBanco Banco da GNRE. Preencher com o código do banco onde foi recolhida a GNRE
     * @param int $gnreAgencia Agência onde foi efetuado o recolhimento
     * @param string $gnreNumero Número de autenticação bancária do documento de arrecadação
     * @param string $valorTotal Valor do GNRE (com 2 decimais)
     * @param DateTime $dataIcms Data do vencimento do ICMS substituído
     * @param DateTime $mesAno Mês e ano referente à ocorrência do fato gerador, formato AAAA-MM
     * @param string $convenio Preencher com o conteúdo do campo 15 da GNRE
     * @param string $inscricaoEstadual Inscrição estadual do remetente nas entradas e do destinatário nas saídas
     *
     * @throws ElementValidation
     */
    public function __construct(
        string $cnpj,
        DateTime $dataGnre,
        string $ufSubstituto,
        string $ufFavorecido,
        int $gnreBanco,
        int $gnreAgencia,
        string $gnreNumero,
        string $valorTotal,
        DateTime $dataIcms,
        DateTime $mesAno,
        string $convenio,
        string $inscricaoEstadual = 'ISENTO',
    ) {
        parent::__construct(Records::REGISTRO_55);

        $this->cnpj = $cnpj;
        $this->inscricaoEstadual = $inscricaoEstadual;
        $this->dataGnre = $dataGnre;
        $this->ufSubstituto = $ufSubstituto;
        $this->ufFavorecido = $ufFavorecido;
        $this->gnreBanco = (string) $gnreBanco;
        $this->gnreAgencia = (string) $gnreAgencia;
        $this->gnreNumero = $gnreNumero;
        $this->valorTotal = $valorTotal;
        $this->dataIcms = $dataIcms;
        $this->mesAno = $mesAno;
        $this->convenio = $convenio;

        $this->validate();
        $this->format();
    }
}
