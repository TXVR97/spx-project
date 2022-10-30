<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/admin')]
class RegistrationController extends AbstractController
{
    

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    

    #[Route('/register/les-utilisateurs', name: 'les_utilisateurs', methods: ['GET', 'POST'])]
    public function service(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('registration/show.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/register/les-utilisateurs/supprimer/{id}', name: 'delete_user', methods: ['GET', 'POST'])]
    
    public function deleteuser(EntityManagerInterface $manager, User $user, int $id, UserRepository $userRepository) : Response 
    {
        $user = $userRepository->findOneBy(["id" => $id]);
        $manager->remove($user);
        $manager->flush();

        return $this-> redirectToRoute('les_utilisateurs');

    }
}
