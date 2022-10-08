<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartCreateController extends AbstractController
{
    #[Route('/admin/ajouter_partenaire', name: 'app_part_create')]
    public function index(): Response
    {
        return $this->render('part_create/index.html.twig', [
            'controller_name' => 'PartCreateController',
        ]);
    }
}
