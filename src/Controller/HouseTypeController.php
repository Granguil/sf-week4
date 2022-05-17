<?php

namespace App\Controller;

use App\Entity\HouseType;
use App\Form\HouseTypeType;
use App\Repository\HouseTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/house/type')]
class HouseTypeController extends AbstractController
{
    #[Route('/', name: 'app_house_type_index', methods: ['GET'])]
    public function index(HouseTypeRepository $houseTypeRepository): Response
    {
        return $this->render('house_type/index.html.twig', [
            'house_types' => $houseTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_house_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HouseTypeRepository $houseTypeRepository): Response
    {
        $houseType = new HouseType();
        $form = $this->createForm(HouseTypeType::class, $houseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $houseTypeRepository->add($houseType, true);

            return $this->redirectToRoute('app_house_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('house_type/new.html.twig', [
            'house_type' => $houseType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_house_type_show', methods: ['GET'])]
    public function show(HouseType $houseType): Response
    {
        return $this->render('house_type/show.html.twig', [
            'house_type' => $houseType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_house_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HouseType $houseType, HouseTypeRepository $houseTypeRepository): Response
    {
        $form = $this->createForm(HouseTypeType::class, $houseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $houseTypeRepository->add($houseType, true);

            return $this->redirectToRoute('app_house_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('house_type/edit.html.twig', [
            'house_type' => $houseType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_house_type_delete', methods: ['POST'])]
    public function delete(Request $request, HouseType $houseType, HouseTypeRepository $houseTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$houseType->getId(), $request->request->get('_token'))) {
            $houseTypeRepository->remove($houseType, true);
        }

        return $this->redirectToRoute('app_house_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
