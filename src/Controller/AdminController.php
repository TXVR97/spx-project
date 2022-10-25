<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PartnerRepository;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{


    #[Route('/admin', name: 'app_admin')]
    public function index(PartnerRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/admin/new', name: 'ajout_partneaire', methods: ['GET', 'POST'])]
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



    #[Route('/admin/ajout-service', name: 'ajout_service', methods: ['GET', 'POST'])]
    public function ajout_permission(Request $request, EntityManagerInterface $manager): Response
    {

        $permission = new Permission();
        $form_service = $this->createForm(PermissionType::class, $permission);
        $form_service->handleRequest($request);

        if ($form_service->isSubmitted() ) { 
            
            $manager->persist($permission);
            $manager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('permission/new_permission.html.twig', [
            'form_service' => $form_service->createView()
        ]);
    }

    #[Route('/admin/ajout-service/services', name: 'les_services', methods: ['GET', 'POST'])]
    public function service(PermissionRepository $permissionRepository): Response
    {
        $permissions = $permissionRepository->findAll();
        return $this->render('permission/show.html.twig', [
            'permissions' => $permissions,
        ]);
    }

    #[Route('/admin/ajout-service/services/supprimer/{id}', name: 'service_delete', methods: ['GET', 'POST'])]
    
    public function delete(EntityManagerInterface $manager, Permission $permission, int $id, PermissionRepository $permissionRepository) : Response 
    {
        $permission = $permissionRepository->findOneBy(["id" => $id]);
        $manager->remove($permission);
        $manager->flush();

        return $this-> redirectToRoute('app_admin');

    }



    

}
