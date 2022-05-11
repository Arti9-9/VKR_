<?php

namespace App\Form;

use App\Entity\Equipment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Наименование оборудования',
            ])
            ->add('Category', ChoiceType::class, [
                'label' => 'Категория',
                'choices' => [
                    'Технические средства' => 'Технические средства',
                    'По' => 'ПО',
                    'Лабораторные устоновки' => 'Лабораторные устоновки',
                    'Спорт инвертарь' => 'Спорт инвертарь',
                    'Прочее' => 'Прочее',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
