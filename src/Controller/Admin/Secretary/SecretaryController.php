<?php

namespace App\Controller\Admin\Secretary;

use App\Controller\APIController;
use App\Entity\User;
use App\Form\SecretaryType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class SecretaryController extends AbstractController
{
    #[Route('/secretary/create', name: 'app_secretary_create')]
    public function create(Request $request, UserRepository $userRepository, APIController $apiController, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        $secretary = new User();
        $form = $this->createForm(SecretaryType::class, $secretary)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $secretary->setPassword(
                $userPasswordHasher->hashPassword(
                    $secretary,
                    $form->get('password')->getData()
                )
            );
            $secretary->setRoles(['ROLE_SECRETARY']);

            $entityManager->persist($secretary);
            $entityManager->flush();

            // Ajouter un message de succès et rediriger l'utilisateur
            $this->addFlash('success', 'Le secrétaire a été créé avec succès.');

            return $this->redirectToRoute('app_secretary_list');
        }

        // Rendre le formulaire dans la vue
        return $this->render('admin/Secretary/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/secretary/list', name: 'app_secretary_list')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager)
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        // Utilisation de findBy pour récupérer tous les utilisateurs ayant le rôle ROLE_DOCTOR
        $secretaries = $userRepository->findSecretaries();

        return $this->render('admin/Secretary/list.html.twig', [
            'secretaries' => $secretaries,
            'user' => $user,
        ]);
    }
}
