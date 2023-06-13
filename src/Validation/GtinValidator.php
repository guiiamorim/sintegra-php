<?php

declare(strict_types=1);

namespace NFePHP\Sintegra\Validation;

use Symfony\Component\Validator\Constraint;

final class GtinValidator extends \Symfony\Component\Validator\ConstraintValidator
{
    /**
     * @inheritDoc
     *
     * @throws \Exception
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! class_exists(\NFePHP\Gtin\Gtin::class)) {
            throw new \Exception('O componente nfephp-org/sped-gtin é necessário para utilizar esta validação.');
        }

        try {
            $isValid = \NFePHP\Gtin\Gtin::check($value)->isValid();
        } catch (\Throwable $e) {
            $isValid = false;
        }

        if (! $isValid) {
            $this->context->setNode(
                $this->context->getValue(),
                $this->context->getObject(),
                $this->context->getMetadata(),
                $constraint->path ?? $this->context->getPropertyPath(),
            );
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ document }}', $value)
                ->addViolation();
        }
    }
}
