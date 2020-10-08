<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;

trait SalesPriceableTrait
{
    public function initSalesPriceableTrait(): void
    {
        $this->salesPrices = new ArrayCollection();
    }

    /** @var SalesPriceInterface[]|ArrayCollection */
    protected $salesPrices;

    /**
     * Returns all sales prices for this product variant.
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPrices(): array
    {
        if ($this->salesPrices === null) {
            $this->salesPrices = new ArrayCollection();
        }

        return $this->salesPrices->toArray();
    }

    /**
     * Returns the sales prices only for one channel
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPricesForChannel(ChannelInterface $channel, string $priceGroup): array
    {
        $channelSalesPrices = \array_filter($this->getSalesPrices(), static function (SalesPriceInterface $salesPrice) use ($channel) {
            $salesPriceChannel = $salesPrice->getChannel();

            return $salesPriceChannel !== null && $salesPriceChannel->getId() === $channel->getId();
        });

        return $this->filterPricesWithPriceGroup($channelSalesPrices, $priceGroup);
    }

    /**
     * Returns the sales prices only for one channel
     *
     * @return SalesPriceInterface[]
     */
    public function getSalesPricesForChannelCode(string $code, string $priceGroup): array
    {
        $channelSalesPrices = \array_filter($this->getSalesPrices(), static function (SalesPriceInterface $salesPrice) use ($code) {
            $salesPriceChannel = $salesPrice->getChannel();

            return $salesPriceChannel !== null && $salesPriceChannel->getCode() === $code;
        });

        return $this->filterPricesWithPriceGroup($channelSalesPrices, $priceGroup);
    }

    /**
     * Removes a sales price from the array collection
     */
    public function removeSalesPrice(SalesPriceInterface $salesPrice): void
    {
        $this->salesPrices->removeElement($salesPrice);
    }

    /**
     * Adds an element to the list
     */
    public function addSalesPrice(SalesPriceInterface $salesPrice): void
    {
        $salesPrice->setProductVariant($this);

        $this->salesPrices->add($salesPrice);
    }

    /**
     * Sets the sales prices form the array collection
     */
    public function setSalesPrices(array $salesPrices): void
    {
        if (!$this instanceof ProductVariantInterface) {
            return;
        }

        $this->salesPrices = new ArrayCollection();

        foreach ($salesPrices as $salesPrice) {
            /** @var SalesPriceInterface $salesPrice */
            $this->addSalesPrice($salesPrice);
        }
    }

    /**
     * @param SalesPriceInterface[] $salesPrices
     *
     * @return SalesPriceInterface[]
     */
    private function filterPricesWithPriceGroup(array $salesPrices, string $priceGroup): array
    {
        return \array_filter($salesPrices, static function (SalesPriceInterface $salesPrice) use ($priceGroup) {
            if ($salesPrice->getStartingDate() !== null && $salesPrice->getStartingDate() > new \DateTime()) {
                return false;
            }

            if ($salesPrice->getEndingDate() !== null && $salesPrice->getEndingDate()->setTime(23, 59, 59) < new \DateTime()) {
                return false;
            }

            return $salesPrice->getPriceGroup() === $priceGroup;
        });
    }
}
