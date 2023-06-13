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

use NFePHP\Sintegra\Exceptions\ElementNotAllowed;
use NFePHP\Sintegra\Exceptions\ElementNotFound;

/**
 * Classe abstrata basica de onde cada bloco é cunstruido
 */
abstract class BlockBase implements Block
{
    /**
     * @var array<string>
     */
    protected array $allowedTypes = [];
    /**
     * @var array<Element>
     */
    protected array $elements = [];
    protected int $elementTotal = 0;

    public function __toString(): string
    {
        $block = '';
        foreach ($this->elements as $element) {
            $block .= $element . "\r\n";
        }

        return $block;
    }

    /**
     * @return BlockBase
     *
     * @throws ElementNotAllowed
     */
    public function addElement(Element $element): self
    {
        if (! in_array($element::class, $this->allowedTypes)) {
            throw new ElementNotAllowed(static::class, $element::class);
        }

        $this->elements[] = $element;
        $this->elementTotal++;

        if (count($this->elements) > 1) {
            usort($this->elements, function ($a, $b) {
                if ($a::class === $b::class) {
                    return 0;
                }

                return array_search($a::class, $this->allowedTypes) > array_search($b::class, $this->allowedTypes)
                    ? 1
                    : -1;
            });
        }

        return $this;
    }

    /**
     * @throws ElementNotFound
     */
    public function getElement(int $index): Element
    {
        if (! isset($this->elements[$index])) {
            throw new ElementNotFound();
        }

        return $this->elements[$index];
    }

    public function total(): int
    {
        return $this->elementTotal;
    }
}
