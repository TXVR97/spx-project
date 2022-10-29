<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Entity\Partfilter;
use App\Form\FilterPartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{


    #[Route('/admin', name: 'app_admin')]
    public function index(PartnerRepository $partnerRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $partfilter = new PartFilter();

        $form_filter = $this->createForm(FilterPartnerType::class, $partfilter);
        $form_filter->handleRequest($request);

    

        $partners = $paginatorInterface->paginate(
            $partnerRepository->findAllWithPagination($partfilter),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('admin/index.html.twig', [
            'partners' => $partners,
            'form_filter' => $form_filter->createView()
        ]);

        
    }

    #[Route('/admin/ajout-partenaire', name: 'ajout_partneaire', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $partner->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($partner);
            $manager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('partner/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



    

    



    

}
