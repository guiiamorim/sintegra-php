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
 * Classe constutora do bloco 8 Sintegra  Informações de exportações
 *
 * Esta classe irá usar um recurso para invocar as classes de cada um dos elementos
 * constituintes listados.
 */
final class Block8 extends BlockBase
{
    /**
     * @var array<string>
     */
    protected array $allowedTypes = [
        Elements\Z85::class,
        Elements\Z86::class,
        Elements\Z88DV::class,
        Elements\Z88EAN::class,
        Elements\Z88SME::class,
        Elements\Z88SMS::class,
        Elements\Z88STES::class,
        Elements\Z88STITNF::class,
    ];
}
