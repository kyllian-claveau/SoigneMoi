<?php

namespace App\Controller\Admin\Schedule;

use App\Controller\APIController;
use App\Entity\Schedule;
use App\Entity\Stay;
use App\Entity\User;
use App\Form\ScheduleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class ScheduleController extends AbstractController
{
    #[Route('/schedule/{doctorId}/create', name: 'app_schedule_create')]
    public function create(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager, int $doctorId): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        $doctor = $entityManager->getRepository(User::class)->find($doctorId);
        if (!$doctor) {
            throw $this->createNotFoundException('Le médecin avec l\'identifiant ' . $doctorId . ' n\'existe pas.');
        }

        $schedule = new Schedule();
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schedule->setDoctor($doctor);
            $entityManager->persist($schedule);
            $entityManager->flush();

            $this->addFlash('success', 'Le rendez-vous a été ajouté avec succès.');

            return $this->redirectToRoute('app_schedule_list');
        }

        return $this->render('admin/Schedule/create.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/doctor/{id}', name: 'app_doctor_show')]
    public function show(Request $request, UserRepository $userRepository, APIController $apiController,int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        // Récupérer le médecin en fonction de l'ID
        $doctor = $entityManager->getRepository(User::class)->find($id);

        // Vérifier si le médecin existe
        if (!$doctor) {
            throw $this->createNotFoundException('Le médecin avec l\'id '.$id.' n\'existe pas.');
        }

        return $this->render('admin/Schedule/show.html.twig', [
            'doctor' => $doctor,
            'user' => $user,
        ]);
    }

    #[Route('/doctor/{id}/events', name: 'app_doctor_events')]
    public function events(Request $request, UserRepository $userRepository, APIController $apiController, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        // Récupérer les séjours du médecin en fonction de l'ID
        $stays = $entityManager->getRepository(Stay::class)->findBy(['doctor' => $id]);

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

        // Retourner une réponse JSON avec les événements
        return new JsonResponse($events);
    }

    #[Route('/schedules', name: 'app_schedule_list')]
    public function index(Request $request, UserRepository $userRepository, APIController $apiController,EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        $schedules = $entityManager->getRepository(Schedule::class)->findAll();

        return $this->render('admin/Schedule/list.html.twig', [
            'schedules' => $schedules,
            'user' => $user,
        ]);
    }
}
