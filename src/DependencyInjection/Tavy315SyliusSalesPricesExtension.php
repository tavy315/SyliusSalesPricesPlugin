<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class Tavy315SyliusSalesPricesExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container): void
    {
        $this->processConfiguration($this->getConfiguration([], $container), $config);
        new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    }
}
