<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Entity;

use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableInterface;

interface ProductVariantInterface extends SalesPriceableInterface
{
    public function removeSalesPrice(SalesPriceInterface $salesPrice): void;

    public function addSalesPrice(SalesPriceInterface $salesPrice): void;
}
