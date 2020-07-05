<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Form;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPrice;

class SalesPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('channel', ChannelChoiceType::class, [
            'attr' => ['style' => 'display:none'],
        ]);

        $builder->add('price', MoneyType::class, [
            'currency' => $options['currency'],
            'label' => 'sylius.ui.price',
            'required' => true,
        ]);

        $builder->add('priceGroup', TextType::class, [
            'required' => true,
        ]);

        $builder->add('qty', NumberType::class, [
            'label' => 'sylius.ui.amount',
            'required' => true,
        ]);

        $builder->add('startingDate', DateType::class, [
            'required' => false,
            'widget' => 'single_text',
        ]);

        $builder->add('endingDate', DateType::class, [
            'required' => false,
            'widget' => 'single_text',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['currency']);
        $resolver->setDefaults([
            'currency' => 'USD',
            'data_class' => SalesPrice::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'tavy315_sylius_sales_price';
    }
}
