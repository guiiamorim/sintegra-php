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

namespace NFePHP\Sintegra;

use NFePHP\Sintegra\Blocks\Block1;
use NFePHP\Sintegra\Blocks\Block5;
use NFePHP\Sintegra\Blocks\Block6;
use NFePHP\Sintegra\Blocks\Block7;
use NFePHP\Sintegra\Blocks\Block8;
use NFePHP\Sintegra\Common\Block;
use NFePHP\Sintegra\Common\Records;
use NFePHP\Sintegra\Elements\Z10;

/**
 * Classe construtora do arquivo SINTEGRA
 *
 * Esta classe recebe as classes listadas com o metodo add() e
 * executa o processo de construção final do arquivo
 */
final class Sintegra
{
    public const LINE_90_TOTAL_CHARS = 125;
    public const LINE_90_START_CHAR_COUNT = 30;
    public const CHAR_COUNT_PER_RECORD = 10;

    /**
     * @var array<string>
     */
    private array $allowedTypes = [
        Block1::class,
        Block5::class,
        Block6::class,
        Block7::class,
        Block8::class,
    ];
    /**
     * @var array<Block>
     */
    private array $blocks = [];

    /**
     * Create a SINTEGRA string
     */
    public function __toString(): string
    {
        $sintegra = implode('', $this->blocks);
        $sintegra .= $this->totalize($sintegra);

        return $sintegra;
    }

    /**
     * Add blocks to class. The blocks are added in the order they appear in the allowedTypes property.
     */
    public function addBlock(Block $block): Sintegra
    {
        $blockPosition = array_search($block::class, $this->allowedTypes);
        if ($blockPosition !== false) {
            $this->blocks[$blockPosition] = $block;
            ksort($this->blocks, SORT_NUMERIC);
        }

        return $this;
    }

    /**
     * Build Sintegra class and add all blocks
     *
     * @param array<Block> $blocks
     */
    public static function build(array $blocks): Sintegra
    {
        $sintegra = new self();
        foreach ($blocks as $block) {
            $sintegra->addBlock($block);
        }

        return $sintegra;
    }

    /**
     * Totals blocks contents
     */
    private function totalize(string $sintegra): string
    {
        /** @var Z10 $z10 */
        $z10 = $this->blocks[0]->getElement(0);
        $inicioLinha = Records::REGISTRO_90->value . $z10->getCnpj() . $z10->getInscricaoEstadual();

        $somatorioPorBloco = $this->getSomatorioPorBloco($sintegra);
        $totalizadoresLinhas = $this->getTotalizadoresRegistro90($somatorioPorBloco, $inicioLinha);
        $registro90 = '';
        $totalLinhasRegistro = count($totalizadoresLinhas);
        foreach ($totalizadoresLinhas as $linha) {
            $strTotalLinhasRegistro = (string) $totalLinhasRegistro;
            $complementoLinha = str_pad($strTotalLinhasRegistro, 126 - strlen($linha), ' ', STR_PAD_LEFT) . "\r\n";
            $registro90 .= $linha . $complementoLinha;
        }
        return $registro90;
    }

    /**
     * Get array of total lines by block
     *
     * @return array<int>
     */
    private function getSomatorioPorBloco(string $sintegra): array
    {
        $somatorioPorBloco = [
            Records::REGISTRO_10->value => 0,
            Records::REGISTRO_11->value => 0,
            Records::REGISTRO_50->value => 0,
            Records::REGISTRO_51->value => 0,
            Records::REGISTRO_53->value => 0,
            Records::REGISTRO_54->value => 0,
            Records::REGISTRO_55->value => 0,
            Records::REGISTRO_56->value => 0,
            Records::REGISTRO_60->value => 0,
            Records::REGISTRO_61->value => 0,
            Records::REGISTRO_70->value => 0,
            Records::REGISTRO_71->value => 0,
            Records::REGISTRO_74->value => 0,
            Records::REGISTRO_75->value => 0,
            Records::REGISTRO_76->value => 0,
            Records::REGISTRO_77->value => 0,
            Records::REGISTRO_85->value => 0,
            Records::REGISTRO_86->value => 0,
            Records::REGISTRO_88->value => 0,
        ];
        foreach ($somatorioPorBloco as $key => $value) {
            $somatorio = preg_match_all("/^{$key}|\r\n{$key}/", $sintegra);
            if ($somatorio !== false) {
                $somatorioPorBloco[$key] = $somatorio;
            }
        }

        return array_filter($somatorioPorBloco);
    }

    /**
     * Get array containing lines of register 90 with the totalizers
     *
     * @param array<int> $somatorioPorBloco
     * @param String $inicioLinha
     *
     * @return array<string>
     */
    private function getTotalizadoresRegistro90(array $somatorioPorBloco, string $inicioLinha): array
    {
        $totalGeral = 0;
        $totalizadoresLinhas = [];

        $totalGeral += $somatorioPorBloco[Records::REGISTRO_10->value];
        $totalGeral += $somatorioPorBloco[Records::REGISTRO_11->value];
        unset($somatorioPorBloco[Records::REGISTRO_10->value], $somatorioPorBloco[Records::REGISTRO_11->value]);

        $charsDisponiveis = self::LINE_90_TOTAL_CHARS - self::LINE_90_START_CHAR_COUNT;
        $maxRegistrosLinha = (int) floor($charsDisponiveis / self::CHAR_COUNT_PER_RECORD);
        $offset = 0;
        while ($registrosLinha = array_slice($somatorioPorBloco, $offset, $maxRegistrosLinha, true)) {
            $offset += $maxRegistrosLinha;
            $totalGeral += array_reduce($registrosLinha, static fn ($carry, $item): int => $carry + $item, 0);

            $linha = '';
            array_walk($registrosLinha, static function ($value, $key) use (&$linha): void {
                $linha .= $key . str_pad((string) $value, 8, '0', STR_PAD_LEFT);
            });
            $totalizadoresLinhas[] = $inicioLinha . $linha;
        }
        $totalGeral += 1;
        $totalizador99 = Records::TOTALIZADOR_99->value . str_pad((string) $totalGeral, 8, '0', STR_PAD_LEFT);

        $lastLine = end($totalizadoresLinhas);
        if (strlen($lastLine . $totalizador99) > self::LINE_90_TOTAL_CHARS) {
            $totalizadoresLinhas[] = $inicioLinha . $totalizador99;
        } else {
            $lastLine .= $totalizador99;
            array_pop($totalizadoresLinhas);
            $totalizadoresLinhas[] = $lastLine;
        }

        return $totalizadoresLinhas;
    }
}
