<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;
use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableInterface;

interface SalesPriceRepositoryInterface extends ObjectRepository
{
    /**
     * Gets all sales prices for a product variant for a channel and optionally customer group with quantity in ascending order
     *
     * @return SalesPriceInterface[]
     */
    public function getSortedSalesPrices(SalesPriceableInterface $productVariant, ChannelInterface $channel, string $priceGroup): array;

    /**
     * Gets a sales price by product variant and quantity
     */
    public function getSalesPriceForQuantity(SalesPriceableInterface $productVariant, ChannelInterface $channel, string $priceGroup, int $quantity): ?SalesPriceInterface;
}
