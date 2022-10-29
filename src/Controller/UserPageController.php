<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserPageController extends AbstractController
{

    


    #[Route('/user', name: 'userpage', methods: ['GET'])]
    public function index( StructureRepository $structureRepository): Response
    {   
        $userstructure = $structureRepository->findAll();
        return $this->render ('user_page/index2.html.twig', [
            'userstructure' => $userstructure

        ]);

        
    }

     
}
