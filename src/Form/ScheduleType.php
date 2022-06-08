<?php

namespace App\Form;

use App\Entity\Attribute;
use App\Entity\Auditorium;
use App\Entity\Schedule;
use App\Repository\AuditoriumRepository;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\ClassString;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('auditorium', EntityType::class,[
                'class' => Auditorium::class,
                'query_builder'=> function(EntityRepository $er){
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.Number', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
