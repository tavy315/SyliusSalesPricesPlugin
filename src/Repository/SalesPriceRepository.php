<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPrice;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;
use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableInterface;

final class SalesPriceRepository extends EntityRepository implements SalesPriceRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(SalesPrice::class));
    }

    /**
     * @return SalesPriceInterface[]
     */
    public function getSortedSalesPrices(SalesPriceableInterface $productVariant, ChannelInterface $channel, string $priceGroup): array
    {
        return $this->findBy([
            'channel' => $channel,
            'priceGroup' => $priceGroup,
            'productVariant' => $productVariant,
        ], ['qty' => 'ASC']);
    }

    public function getSalesPriceForQuantity(SalesPriceableInterface $productVariant, ChannelInterface $channel, string $priceGroup, int $quantity): ?SalesPriceInterface
    {
        $result = $this->findOneBy([
            'channel' => $channel,
            'priceGroup' => $priceGroup,
            'productVariant' => $productVariant,
            'qty' => $quantity,
        ]);

        return $result instanceof SalesPriceInterface ? $result : null;
    }
}
