<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

class SalesPrice implements ResourceInterface, SalesPriceInterface
{
    /** @var int */
    private $id;

    /** @var int */
    private $price;

    /** @var int */
    private $qty;

    /** @var ChannelInterface|null */
    private $channel;

    /** @var ProductVariantInterface */
    private $productVariant;

    /** @var string */
    private $priceGroup = '';

    /** @var ?\DateTimeInterface */
    private $startingDate;

    /** @var ?\DateTimeInterface */
    private $endingDate;

    public function __construct(int $quantity = 0, int $price = 0)
    {
        $this->qty = $quantity;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): void
    {
        $this->qty = max($qty, 0);
    }

    public function getProductVariant(): ProductVariantInterface
    {
        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant): void
    {
        $this->productVariant = $productVariant;
    }

    public function getChannel(): ?ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(?ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }

    public function getPriceGroup(): string
    {
        return $this->priceGroup;
    }

    public function setPriceGroup(string $priceGroup): void
    {
        $this->priceGroup = $priceGroup;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->startingDate;
    }

    public function setStartingDate(?\DateTimeInterface $startingDate): self
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->endingDate;
    }

    public function setEndingDate(?\DateTimeInterface $endingDate): self
    {
        $this->endingDate = $endingDate;

        return $this;
    }
}
