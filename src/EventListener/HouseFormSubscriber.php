<?php

namespace App\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Validator\Constraints\NotBlank;
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
            FormEvents::PRE_SUBMIT=> 'onHouseSubmit'
        ];
    }

    public function onHouseSubmit(FormEvent $event)
    {
            $house = $event->getData();
            $form = $event->getForm();
    
            // checks whether the user has chosen to display their email or not.
            // If the data was submitted previously, the additional value that is
            // included in the request variables needs to be removed.
            if ($form->has('zipcode') && !$form->has('city')) {
                $zipcode=$house['zipcode'];
                $conn = $this->em->getConnection();
                    $sql = '
                    SELECT ville_slug FROM spec_villes_france_free
                    WHERE ville_code_postal = :code
                    ';
                    $stmt = $conn->prepare($sql);
                    $resultSet = $stmt->executeQuery(['code' => $zipcode]);

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