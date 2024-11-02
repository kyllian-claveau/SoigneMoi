<?php

namespace App\Controller\Doctor\Dashboard;

use App\Controller\APIController;
use App\Entity\Stay;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/doctor')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_doctor_dashboard')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_DOCTOR', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('doctor/Dashboard/dashboard.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/schedule', name: 'app_doctor_show_schedule')]
    public function show(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_DOCTOR', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }

        $doctor = $entityManager->getRepository(User::class)->find($user->getId());

        if (!$doctor) {
            throw $this->createNotFoundException('Le médecin connecté n\'existe pas.');
        }

        return $this->render('doctor/Dashboard/showSchedule.html.twig', [
            'doctor' => $doctor,
            'user' => $user,
        ]);
    }

    #[Route('/events', name: 'app_doctor_events_schedule')]
    public function events(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_DOCTOR', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }

        // Récupérer les séjours du médecin connecté
        $stays = $entityManager->getRepository(Stay::class)->findBy(['doctor' => $user->getId()]);

        // Créer un tableau d'événements à partir des séjours
        $events = [];
        foreach ($stays as $stay) {
            $title = $stay->getUser()->getFirstname() . ' ' . $stay->getUser()->getLastname() . ' : ' . $stay->getReason();

            $events[] = [
                'title' => $title,
                'start' => $stay->getStartDate()->format('Y-m-d'),
                'end' => $stay->getEndDate()->modify('+1 day')->format('Y-m-d'), // Ajouter 1 jour à la date de fin
            ];
        }

        return new JsonResponse($events);
    }
}