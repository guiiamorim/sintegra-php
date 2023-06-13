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

use NFePHP\Sintegra\Common\ElementBase;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Formatters as Format;
use Symfony\Component\Validator\Constraints as Assert;

final class Z11 extends ElementBase
{
    #[Assert\NotBlank(message: 'O logradouro é obrigatório.')]
    #[Assert\Regex('/^.{2,34}$/')]
    #[Format\Text(34)]
    protected string $logradouro;

    #[Assert\NotBlank(message: 'O número do endereço é obrigatório.')]
    #[Format\Number(5)]
    protected string $numero;

    #[Format\Text(22)]
    protected ?string $complemento = null;

    #[Format\Text(15)]
    protected ?string $bairro = null;

    #[Assert\NotBlank(message: 'O CEP é obrigatório.')]
    #[Assert\Regex('/^\d{5}-?\d{3}/', message: 'Formato do CEP inválido.')]
    #[Format\Number(8)]
    protected string $cep;

    #[Assert\Regex('/^.{2,28}/', message: 'Informe um nome válido para o contato do responsável.')]
    #[Format\Text(28)]
    protected ?string $contato = null;

    #[Assert\NotBlank(message: 'O telefone é obrigatório.')]
    #[Assert\Regex('/^[0-9]{5,12}$/', message: 'Informe um telefone válido.')]
    #[Format\Number(12)]
    protected string $telefone;

    /**
     * Constructor
     *
     * @param string $telefone Telefone do estabelecimento.
     * @param string $logradouro Endereço do estabelcimento.
     * @param string $cep CEP do endereço.
     * @param int $numero Número do endereço.
     * @param string|null $complemento Complemento do endereço.
     * @param string|null $bairro Bairro do estabelecimento
     * @param string|null $contato Nome da pessoa responsavel pelo estabelecimento.
     */
    public function __construct(
        string $telefone,
        string $logradouro,
        string $cep,
        int $numero,
        ?string $complemento = null,
        ?string $bairro = null,
        ?string $contato = null,
    ) {
        parent::__construct(Records::REGISTRO_11);
        $this->logradouro = $logradouro;
        $this->numero = (string) $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cep = $cep;
        $this->contato = $contato;
        $this->telefone = $telefone;
        $this->validate();
        $this->format();
    }
}
