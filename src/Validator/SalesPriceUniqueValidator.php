<?php

declare(strict_types=1);

namespace Tavy315\SyliusSalesPricesPlugin\Validator;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use ReflectionProperty;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Tavy315\SyliusSalesPricesPlugin\Entity\ProductVariantInterface;
use Tavy315\SyliusSalesPricesPlugin\Entity\SalesPriceInterface;
use Webmozart\Assert\Assert;

class SalesPriceUniqueValidator extends ConstraintValidator
{
    /** @var ManagerRegistry */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        Assert::isInstanceOf($value, SalesPriceInterface::class);
        Assert::isInstanceOf($constraint, SalesPriceUniqueConstraint::class);

        /** @var SalesPriceInterface $value */
        $fields = $constraint->fields;
        if (0 === count($fields)) {
            throw new ConstraintDefinitionException('At least one field has to be specified.');
        }

        $em = $this->registry->getManagerForClass(get_class($value));
        if ($em === null) {
            throw new ConstraintDefinitionException(
                sprintf(
                    'Unable to find the object manager associated with an entity of class "%s".',
                    get_class($value)
                )
            );
        }

        $formData = $this->context->getRoot()->getData();
        if ($formData instanceof ProductInterface && $formData->getVariants()->count() === 1) {
            $formData = $formData->getVariants()->first();
        }
        if (!$formData instanceof ProductVariantInterface) {
            throw new ConstraintDefinitionException('Unable to find ProductVariant in form.');
        }
        $otherSalesPrices = $formData->getSalesPrices();

        $otherSalesPrices = array_filter($otherSalesPrices, static function ($salesPrice) use ($value) {
            return $salesPrice !== $value;
        });

        foreach ($otherSalesPrices as $otherSalesPrice) {
            if ($this->areDuplicates($fields, $em, $value, $otherSalesPrice)) {
                $this->context->buildViolation($constraint->message)->atPath($fields[0])->addViolation();

                return;
            }
        }
    }

    private function areDuplicates(array $fields, ObjectManager $em, SalesPriceInterface $first, SalesPriceInterface $second): bool
    {
        /** @var ClassMetadataInfo $class */
        $class = $em->getClassMetadata(get_class($first));

        Assert::isInstanceOf($class, ClassMetadataInfo::class);

        foreach ($fields as $fieldName) {
            if (!$class->hasField($fieldName) && !$class->hasAssociation($fieldName)) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'The field "%s" is not mapped by Doctrine, so it cannot be validated for uniqueness.',
                        $fieldName
                    )
                );
            }
            $fieldValue = $this->getFieldValue($em, $class, $fieldName, $first);
            $otherFieldValue = $this->getFieldValue($em, $class, $fieldName, $second);
            if ($fieldValue !== $otherFieldValue) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    private function getFieldValue(ObjectManager $em, ClassMetadataInfo $class, string $fieldName, SalesPriceInterface $value)
    {
        /** @var ReflectionProperty $fieldMetaData */
        $fieldMetaData = $class->reflFields[$fieldName];

        $fieldValue = $fieldMetaData->getValue($value);

        if (null !== $fieldValue && $class->hasAssociation($fieldName)) {
            /*
             * Ensure the Proxy is initialized before using reflection to
             * read its identifiers. This is necessary because the wrapped
             * getter methods in the Proxy are being bypassed.
             */
            $em->initializeObject($fieldValue);
        }

        return $fieldValue;
    }
}
