<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface;

interface SalesPriceInterface
{
    public function getId(): ?int;

    public function getPrice(): int;

    public function setPrice(int $price): void;

    public function getQty(): int;

    public function setQty(int $qty): void;

    public function getProductVariant(): ProductVariantInterface;

    public function setProductVariant(ProductVariantInterface $productVariant): void;

    public function getChannel(): ?ChannelInterface;

    public function setChannel(?ChannelInterface $channel): void;

    public function getPriceGroup(): string;

    public function setPriceGroup(string $priceGroup): void;

    public function getStartingDate(): ?\DateTimeInterface;

    public function setStartingDate(?\DateTimeInterface $startingDate): self;

    public function getEndingDate(): ?\DateTimeInterface;

    public function setEndingDate(?\DateTimeInterface $endingDate): self;
}
