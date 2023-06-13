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

use NFePHP\Sintegra\Exceptions\ElementValidation;
use NFePHP\Sintegra\Exceptions\RecordLenghtMismatch;
use NFePHP\Sintegra\Formatters\FormatterAttribute;
use Symfony\Component\Validator\Validation;

abstract class ElementBase implements Element
{
    /**
     * Constructor
     */
    public function __construct(
        protected readonly Records $registro,
        protected readonly int $length = 126,
        protected readonly ?string $subtipo = null,
    ) {
    }

    /**
     * Retorna o elemento formatado em uma string
     *
     * @throws \Exception
     */
    public function __toString(): string
    {
        return $this->lineStart() . $this->build();
    }

    /**
     * Validation of element
     *
     * @throws ElementValidation
     */
    final public function validate(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        $errors = $validator->validate($this);
        if ($errors->count() > 0) {
            throw new ElementValidation(
                message: "[Registro {$this->registro->value}] Há erros de validação no elemento.",
                errors: $errors,
            );
        }
    }

    /**
     * Format properties of element
     */
    final public function format(): void
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(
                FormatterAttribute::class,
                \ReflectionAttribute::IS_INSTANCEOF,
            );
            foreach ($attributes as $attribute) {
                $attrInstance = $attribute->newInstance();
                $property->setValue($this, $attrInstance->format($property->getValue($this)));
            }
        }
    }

    /**
     * Construtor do elemento
     *
     * @throws \Exception
     */
    final protected function build(): string
    {
        $register = '';
        foreach (get_object_vars($this) as $key => $value) {
            if (! in_array($key, ['length', 'registro', 'subtipo'])) {
                $register .= $value;
            }
        }
        $lenreg = strlen($register) + strlen($this->subtipo ?? '') + strlen($this->registro->value);
        if ($lenreg !== $this->length) {
            throw new RecordLenghtMismatch(
                "[Registro {$this->lineStart()}]: Tamanho do registro não respeitado. Tamanho esperado / gerado: {$this->length} / {$lenreg}."
            );
        }
        return $register;
    }

    final protected function lineStart(): string
    {
        return $this->registro->value . $this->subtipo;
    }
}
