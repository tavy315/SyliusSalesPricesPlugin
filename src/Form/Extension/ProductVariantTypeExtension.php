<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Tavy315\SyliusSalesPricesPlugin\Form\SalesPriceType;

class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('salesPrices', CollectionType::class, [
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => ['label' => false],
            'entry_type' => SalesPriceType::class,
        ]);
    }

    /**
     * @return iterable<int, string>
     */
    public function getExtendedTypes(): iterable
    {
        return [ProductVariantType::class];
    }
}
