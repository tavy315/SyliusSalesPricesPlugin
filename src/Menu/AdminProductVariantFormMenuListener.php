<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminProductVariantFormMenuListener
{
    public function addItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu->addChild('salesprice', [ 'position' => 2 ])
             ->setAttribute('template', '@Tavy315SyliusSalesPricesPlugin/Admin/ProductVariant/Tab/_salesPrice.html.twig')
             ->setLabel('tavy315_sylius_sales_prices.ui.sales_prices')
             ->setLabelAttribute('icon', 'dollar');
    }
}
