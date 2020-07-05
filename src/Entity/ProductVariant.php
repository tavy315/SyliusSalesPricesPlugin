<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Entity;

use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableTrait;

class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    use SalesPriceableTrait;

    public function __construct()
    {
        parent::__construct();

        $this->initSalesPriceableTrait();
    }
}
