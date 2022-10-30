<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class PermissionController extends AbstractController
{   

    #[Route('/ajout-service', name: 'ajout_service', methods: ['GET', 'POST'])]
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
    
    public function deleteservice(EntityManagerInterface $manager, Permission $permission, int $id, PermissionRepository $permissionRepository) : Response 
    {
        $permission = $permissionRepository->findOneBy(["id" => $id]);
        $manager->remove($permission);
        $manager->flush();

        return $this-> redirectToRoute('les_services');

    }


    #[Route('/admin/ajout-service/services/{id}', name: 'modification_service', methods: ['GET', 'POST'])]
    public function editservice( Permission $permission,Request $request,PermissionRepository $permissionRepository, EntityManagerInterface $entityManager, int $id ): Response
    {
        
        if (!$permission){
            return $this-> redirectToRoute('app_admin');
        }

        $partner = $permissionRepository->findOneBy(["id" => $id]);
        $form_service = $this->createForm(PermissionType::class, $permission);

        $form_service->handleRequest($request);

        if ($form_service->isSubmitted() ) {
            
            
            $entityManager->persist($partner);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('permission/edit.html.twig', [
            'form_service' => $form_service->createView()
        ]);
    }



    
}
