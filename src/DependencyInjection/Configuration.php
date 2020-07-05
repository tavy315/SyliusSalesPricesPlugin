<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('tavy315_sylius_sales_prices_plugin');
    }
}
