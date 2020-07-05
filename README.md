# Sylius Sales Prices Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]

The sales prices plugin for [Sylius](https://sylius.com/) allows you to configure nice badges for different set of products
based on specific rules. It provides a common set of configuration by default and is very flexible when it comes to adding new ones.

Supports Doctrine ORM driver only.

## Installation

### Step 1: Install the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require tavy315/sylius-sales-prices-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in `config/bundles.php` file of your project:

```php
<?php
$bundles = [
    Tavy315\SyliusSalesPricesPlugin\Tavy315SyliusSalesPricesPlugin::class => ['all' => true],
];
```

### Step 3: Configure plugin
```yaml
# config/packages/_sylius.yaml

imports:
    - { resource: '@Tavy315SyliusSalesPricesPlugin/Resources/config/config.yml'}
```

### Step 4: Import routing

```yaml
# config/routes.yaml

tavy315_salesprice_bundle:
    resource: '@Tavy315SyliusSalesPricesPlugin/Resources/config/routing.yml'
```

### Step 5: Customize models

Read more about Sylius models customization [here](https://docs.sylius.com/en/latest/customization/model.html).

#### Customize your ProductVariant model

Add a `Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableTrait` trait to your `App\Entity\Product\ProductVariant` class.

- If you use `annotations` mapping:

    ```php
    <?php 
    // src/Entity/Product/ProductVariant.php
    
    namespace App\Entity\Product;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
    use Tavy315\SyliusSalesPricesPlugin\Entity\ProductVariantInterface;
    use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;
    use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableInterface;
    use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableTrait;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="sylius_product_variant")
     */
    class ProductVariant extends BaseProductVariant implements SalesPriceableInterface, ProductVariantInterface
    {
        use SalesPriceableTrait;
  
        /**
         * @ORM\OneToMany(targetEntity="Tavy315\SyliusSalesPricesPlugin\Entity\SalesPrice", mappedBy="productVariant", orphanRemoval=true, cascade={"all"})
         * @ORM\OrderBy({"priceGroup"="ASC","qty"="ASC"})
         * @var SalesPriceInterface[]|ArrayCollection
         */
        protected $salesPrices;
      
        public function __construct()
        {
            parent::__construct();
  
            $this->initSalesPriceableTrait();
        }
    }
    ```
    
- If you use `xml` mapping:

    ```php
    <?php
    // src/Model/Product/ProductVariant.php
    
    namespace App\Entity\Product;

    use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
    use Tavy315\SyliusSalesPricesPlugin\Entity\ProductVariantInterface;
    use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableInterface;
    use Tavy315\SyliusSalesPricesPlugin\Traits\SalesPriceableTrait;
    
    class ProductVariant extends BaseProductVariant implements SalesPriceableInterface, ProductVariantInterface
    {
        use SalesPriceableTrait;
      
        public function __construct()
        {
            parent::__construct();
  
            $this->initSalesPriceableTrait();
        }
    }
    ```

    ```xml
        <?xml version="1.0" encoding="utf-8"?>
        <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                          xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
            <mapped-superclass name="Tavy315\SyliusSalesPricesPlugin\Entity\SalesPrice"
                               repository-class="Tavy315\SyliusSalesPricesPlugin\Repository\SalesPriceRepository"
                               table="tavy315_sylius_sales_price">
                <id name="id" type="integer" column="id">
                    <generator strategy="AUTO" />
                </id>
                <field name="price" type="integer" column="price" />
                <field name="qty" type="integer" column="qty" />
                <field name="priceGroup" type="string" column="price_group" length="30" />
                <field name="startingDate" type="datetime" column="starting_date" nullable="true" />
                <field name="endingDate" type="datetime" column="ending_date" nullable="true" />
                <many-to-one target-entity="Sylius\Component\Channel\Model\ChannelInterface" field="channel">
                    <join-column name="channel_id" />
                </many-to-one>
                <many-to-one target-entity="Sylius\Component\Product\Model\ProductVariantInterface" field="productVariant" inversed-by="salesPrices">
                    <join-column name="product_variant_id" />
                </many-to-one>
            </mapped-superclass>
        </doctrine-mapping>
    ```

### Step 6: Update your database schema

```bash
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
```

## Usage

From now on you should be able to add new sales prices in the admin panel.


[ico-version]: https://poser.pugx.org/tavy315/sylius-sales-prices-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/tavy315/sylius-sales-prices-plugin/v/unstable
[ico-license]: https://poser.pugx.org/tavy315/sylius-sales-prices-plugin/license
[ico-github-actions]: https://github.com/tavy315/SyliusSalesPricesPlugin/workflows/build/badge.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/tavy315/SyliusSalesPricesPlugin.svg

[link-packagist]: https://packagist.org/packages/tavy315/sylius-sales-prices-plugin
[link-github-actions]: https://github.com/tavy315/SyliusSalesPricesPlugin/actions
