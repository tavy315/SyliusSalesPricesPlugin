<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Menu;

use Sylius\Bundle\AdminBundle\Event\ProductMenuBuilderEvent;

final class AdminProductFormMenuListener
{
    public function addItems(ProductMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if ($event->getProduct()->isConfigurable()) {
            return;
        }

        $menu->addChild('salesprice')
             ->setAttribute('template', '@Tavy315SyliusSalesPricesPlugin/Admin/ProductVariant/Tab/_salesPrice.html.twig')
             ->setLabel('tavy315_sylius_sales_prices.ui.sales_prices')
             ->setLabelAttribute('icon', 'dollar');
    }
}
