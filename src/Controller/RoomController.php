<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\House;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    #[Route('/{house}/room/create', name: 'app_room_house')]
    #[Route('/{house}/room/edit/{room}', name: 'app_edit_room_house')]
    public function create(House $house,Room $room = null, RoomRepository $roomRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('edit', $house);
        if($room == null){
            $room=new Room();
        }
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room->setHouse($house);
            foreach($room->getRoomLines() as $roomLine)
            {
                $roomLine->setRoom($room);
            }
            $roomRepository->add($room, true);

            return $this->redirectToRoute('app_house_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/new.html.twig', [
            'form' => $form,
            'house'=>$house,
            'room'=>$room
        ]);
    }
}
