<?php

namespace App\Controller;
use App\Entity\Partner;
use App\Entity\Structure;
use App\Form\PartnerType;
use App\Entity\Permission;
use App\Form\StructureType;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use App\Repository\PermissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    public function index($slug, StructureRepository $structureRepository): Response
    {   
        
        $structures = $structureRepository->findAll();
        $partner = $this->entityManager->getRepository(Partner::class)->findOneBySlug($slug);

        if (!$partner){
            return $this-> redirectToRoute('app_admin');
        }

        return $this->render('details/index.html.twig', [
            'partner' => $partner,
            'structures' => $structures,
                       
        ]);
    }

    
    #[Route('/admin/details/supprimer/{id}', name: 'structure_delete', methods: ['GET', 'POST'])]
    
    public function delete(EntityManagerInterface $manager, Structure $structure, int $id, StructureRepository $structureRepository) : Response 
    {
        $structure = $structureRepository->findOneBy(["id" => $id]);
        $manager->remove($structure);
        $manager->flush();

        return $this-> redirectToRoute('app_admin');

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

  


    #[Route('/admin/details/{slug}/ajout-structure', name: 'ajout_structure', methods: ['GET', 'POST'])]
    public function add_structure(Request $request, EntityManagerInterface $manager ): Response
    {
        
        
        
        $structure = new Structure();
        $form_structure = $this->createForm(StructureType::class, $structure);
        $form_structure->handleRequest($request);

        if ($form_structure->isSubmitted() ) {
            $structure->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($structure);
            $manager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('structure/new_structure.html.twig', [
            
            'form_structure' => $form_structure->createView()
        ]);
    }
    

    #[Route('/admin/details/{slug}/modifier', name: 'modification_structure', methods: ['GET', 'POST'])]
    public function edit_structure( Structure $structure,Request $request,StructureRepository $structureRepository, $slug, EntityManagerInterface $entityManager): Response
    {
        
        if (!$structure){
            return $this-> redirectToRoute('app_admin');
        }

        $structure = $structureRepository->findOneBy(["slug" => $slug]);
        $form_structure = $this->createForm(StructureType::class, $structure);

        $form_structure->handleRequest($request);

        if ($form_structure->isSubmitted() ) {
            
            
            $entityManager->persist($structure);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('structure/edit.html.twig', [
            'form_structure' => $form_structure->createView()
        ]);
    }
    
}
