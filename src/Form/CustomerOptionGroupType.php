<?php

declare(strict_types=1);

namespace Brille24\CustomerOptionsPlugin\Form;

use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionGroup;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CustomerOptionGroupType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius.ui.code',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => CustomerOptionGroupTranslationType::class,
                'label' => 'brille24.form.customer_option_groups.translations',
            ])
            ->add('option_associations', CollectionType::class, [
                'entry_type' => CustomerOptionAssociationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $defaults = [
            'data_class' => CustomerOptionGroup::class,
        ];
        $resolver->setDefaults($defaults);
    }

    public function getBlockPrefix(): string
    {
        return 'brille24_customer_group_option';
    }
}