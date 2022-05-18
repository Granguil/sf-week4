<?php

namespace App\EventListener;

use App\Entity\HouseType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HouseFormSubscriber implements EventSubscriberInterface
{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'onHouseSubmit',
            FormEvents::PRE_SET_DATA =>'onEditHouse'
        ];
    }

    public function onEditHouse(FormEvent $event)
    {
        $house = $event->getData();
        $form = $event->getForm();
        if($house->getId()!=null){
            $form->remove('houseType')
            ->remove("address")
            ->remove('zipcode');
        }
    }

    public function onHouseSubmit(FormEvent $event)
    {
            $house = $event->getData();
            $form = $event->getForm();
    
            
            if ($form->has('zipcode') && !$form->has('city')) {
                $zipcode=$house['zipcode'];
                $conn = $this->em->getConnection();
                    $sql = '
                    SELECT ville_slug FROM spec_villes_france_free
                    WHERE ville_code_postal like :code
                    ';
                    $stmt = $conn->prepare($sql);
                    $resultSet = $stmt->executeQuery(['code' => "%".$zipcode."%"]);

                    $cities = $resultSet->fetchAllAssociative();

                    $citiesList=[];
                    foreach ($cities as $row) {
                        $citiesList[$row["ville_slug"]]=$row["ville_slug"];
                    }
                $form->add('city',ChoiceType::class,[
                    'label'=>'city',
                    'choices'  =>$citiesList,
                    'constraints' => [new NotBlank(["message"=>"Merci de préciser la ville"])]
                ]);
            }
        
    }
}