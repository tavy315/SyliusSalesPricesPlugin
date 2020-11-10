<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class Tavy315SyliusSalesPricesExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $config, ContainerBuilder $container): void
    {
        $this->processConfiguration($this->getConfiguration([], $container), $config);
        new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('doctrine_migrations') || !$container->hasExtension('sylius_labs_doctrine_migrations_extra')) {
            return;
        }

        $container->prependExtensionConfig('doctrine_migrations', [
            'migrations_paths' => [
                'Tavy315\SyliusSalesPricesPlugin\Migrations' => '@Tavy315SyliusSalesPricesPlugin/Migrations',
            ],
        ]);

        $container->prependExtensionConfig('sylius_labs_doctrine_migrations_extra', [
            'migrations' => [
                'Tavy315\SyliusSalesPricesPlugin\Migrations' => [ 'Sylius\Bundle\CoreBundle\Migrations' ],
            ],
        ]);
    }
}
