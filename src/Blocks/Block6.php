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

namespace NFePHP\Sintegra\Blocks;

use NFePHP\Sintegra\Common\BlockBase;
use NFePHP\Sintegra\Elements;

/**
 * Classe constutora do bloco 6 Sintegra  Exclusivo para empresas emissoras de Cupom Fiscal
 *
 * Esta classe irá usar um recurso para invocar as classes de cada um dos elementos
 * constituintes listados.
 */
final class Block6 extends BlockBase
{
    /**
     * @var array<string>
     */
    protected array $allowedTypes = [
        Elements\Z60M::class,
        Elements\Z61::class,
        Elements\Z61R::class,
    ];
}
