<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsController extends AbstractController
{
    #entity manager va servir pour récuperer le slug pluis bas
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/details/{slug}', name: 'details')]
    public function index($slug): Response
    {
        $partner = $this->entityManager->getRepository(Partner::class)->findOneBySlug($slug);

        if (!$partner){
            return $this-> redirectToRoute('app_admin');
        }

        return $this->render('details/index.html.twig', [
            'partner' => $partner,
        ]);
    }


    #[Route('/admin/details/modifier/{slug}', name: 'modification_partenaire', methods: ['GET', 'POST'])]
    public function edit( Partner $partner,Request $request,PartnerRepository $partnerRepository, $slug, EntityManagerInterface $entityManager): Response
    {
        
        if (!$partner){
            return $this-> redirectToRoute('app_admin');
        }

        $partner = $partnerRepository->findOneBy(["slug" => $slug]);
        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $partner->setCreatedAt(new \DateTimeImmutable());
            
            $entityManager->persist($partner);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('partner/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    
}
