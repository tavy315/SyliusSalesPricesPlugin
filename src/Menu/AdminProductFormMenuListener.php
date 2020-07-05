<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Menu;

use Sylius\Bundle\AdminBundle\Event\ProductMenuBuilderEvent;
use Symfony\Component\Translation\Translator;

final class AdminProductFormMenuListener
{
    /** @var Translator */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function addItems(ProductMenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if ($event->getProduct()->isConfigurable()) {
            return;
        }

        $menu->addChild('salesprice')
             ->setAttribute('template', '@Tavy315SyliusSalesPricesPlugin/Admin/ProductVariant/Tab/_salesPrice.html.twig')
             ->setLabel($this->translator->trans('tavy315_sylius_sales_prices.ui.sales_prices'))
             ->setLabelAttribute('icon', 'dollar');
    }
}
