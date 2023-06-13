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

namespace NFePHP\Sintegra\Common;

interface Element
{
    public function __toString(): string;

    /**
     * Este método será usado para validar os dados do elemento
     */
    public function validate(): void;

    /**
     * Este método será utilizado para formatar os dados no
     * formato correto exigido no sintegra
     */
    public function format(): void;
}
