<?php

// src/Controller/DoctorController.php

namespace App\Controller\Admin\Doctor;

use App\Controller\APIController;
use App\Entity\Schedule;
use App\Entity\User;
use App\Form\DoctorType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class DoctorController extends AbstractController
{
    #[Route('/doctor/create', name: 'app_doctor_create')]
    public function create(Request $request, UserRepository $userRepository, APIController $apiController, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        $doctor = new User();
        $form = $this->createForm(DoctorType::class, $doctor)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctor->setPassword(
                $userPasswordHasher->hashPassword(
                    $doctor,
                    $form->get('password')->getData()
                )
            );
            $doctor->setRoles(['ROLE_DOCTOR']);

            // Créer une nouvelle entité Schedule et l'associer au Doctor
            $schedule = new Schedule();
            $schedule->setDoctor($doctor);

            // Persister les entités dans la base de données
            $entityManager->persist($doctor);
            $entityManager->persist($schedule);
            $entityManager->flush();

            // Ajouter un message de succès et rediriger l'utilisateur
            $this->addFlash('success', 'Le médecin a été créé avec succès.');

            return $this->redirectToRoute('app_doctor_list');
        }

        // Rendre le formulaire dans la vue
        return $this->render('admin/Doctor/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/doctor/list', name: 'app_doctor_list')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager)
    {
        $user = $apiController->getUserFromToken($request, $userRepository);

        // Utilisation de findBy pour récupérer tous les utilisateurs ayant le rôle ROLE_DOCTOR
        $doctors = $userRepository->findDoctors();

        return $this->render('admin/Doctor/list.html.twig', [
            'doctors' => $doctors,
            'user' => $user,
        ]);
    }
}
