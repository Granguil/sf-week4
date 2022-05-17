<?php

namespace App\Form;

use App\Entity\House;
use App\Entity\HouseType as Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\EventListener\HouseFormSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HouseType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pricePerNight')
            ->add('description')
            ->add('houseType',EntityType::class,[
                'class' => Type::class,
                'choice_label'=> 'type'])
            ->add("address")
            ->add('zipcode')
            ->addEventSubscriber(new HouseFormSubscriber($this->em))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => House::class,
        ]);
    }
}
