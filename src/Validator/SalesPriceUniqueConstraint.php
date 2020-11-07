<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Validator;

use Symfony\Component\Validator\Constraint;

class SalesPriceUniqueConstraint extends Constraint
{
    /** @var string */
    public $message = 'tavy315_sales_prices.form.validation.not_unique';

    /** @var string[] */
    public $fields = [];

    public function getDefaultOption(): ?string
    {
        return 'fields';
    }

    public function getRequiredOptions(): array
    {
        return ['fields'];
    }

    public function getTargets(): string
    {
        return Constraint::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return SalesPriceUniqueValidator::class;
    }
}
