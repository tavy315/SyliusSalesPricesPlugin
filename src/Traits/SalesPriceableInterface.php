<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Traits;

use Sylius\Component\Core\Model\ChannelInterface;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;

interface SalesPriceableInterface
{
    /**
     * Returns all sales prices for a given channel
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPricesForChannel(ChannelInterface $channel, string $priceGroup): array;

    /**
     * Returns all sales prices for a given channel
     *
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPricesForChannelCode(string $code, string $priceGroup): array;

    /**
     * Returns the sales prices associated
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPrices(): array;

    /**
     * Sets the sales prices from an array
     *
     * @param SalesPriceInterface[] $salesPrices
     */
    public function setSalesPrices(array $salesPrices): void;
}
