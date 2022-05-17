<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    #[Route('/', name: 'app_root_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /*#[Route('/test_sql', name: 'app_sql_test')]
    public function test(EntityManagerInterface $em): void
    {
        $conn = $em->getConnection();
        $sql = '
        SELECT ville_nom FROM spec_villes_france_free
        WHERE ville_code_postal = :code
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['code' => "46100"]);

        $cities = $resultSet->fetchAllAssociative();
        dd($cities);
    }*/
}
