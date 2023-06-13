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
 * REGISTRO '88SME' - Informação sobre mês sem movimento de entradas
 *
 * @see http://www.fazenda.mg.gov.br/empresas/legislacao_tributaria/ricms_2002_seco/anexovii2002_6.html
 */

use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Formatters as Format;
use NFePHP\Sintegra\Validation as Validate;
use Symfony\Component\Validator\Constraints as Assert;

final class Z88SME extends ElementBase
{
    #[Assert\NotBlank(message: 'O CPF / CNPJ é obrigatório.')]
    #[Validate\CpfCnpj]
    #[Format\Number(14)]
    protected string $cnpj;

    #[Assert\NotBlank(message: 'A mensagem é obrigatória.')]
    #[Format\Text(34)]
    protected string $mensagem;

    #[Format\Text(73)]
    protected ?string $brancos = null;

    /**
     * @param string $cnpj CNPJ ou CPF do Informante
     * @param string $mensagem Sem Movimento de Entradas
     *
     * @throws ElementValidation
     */
    public function __construct(string $cnpj, string $mensagem = 'SEM MOVIMENTO DE ENTRADAS')
    {
        parent::__construct(Records::REGISTRO_88, subtipo: 'SME');

        $this->cnpj = $cnpj;
        $this->mensagem = $mensagem;

        $this->validate();
        $this->format();
    }
}
