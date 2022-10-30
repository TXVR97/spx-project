<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserPageController extends AbstractController
{

    


    #[Route('/user', name: 'userpage', methods: ['GET'])]
    public function index(): Response
    {   
        return $this-> render ('user_page/index.html.twig');
    }

     
}
