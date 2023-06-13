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
 * Classe constutora do bloco 050 (notas fiscais de compra e vendde a) Sintegra
 *
 * Esta classe irá usar um recurso para invocar as classes de cada um dos elementos
 * constituintes listados.
 */
final class Block5 extends BlockBase
{
    /**
     * @var array<string>
     */
    protected array $allowedTypes = [
        Elements\Z50::class,
        Elements\Z51::class,
        Elements\Z53::class,
        Elements\Z54::class,
        Elements\Z55::class,
        Elements\Z56::class,
    ];
}
