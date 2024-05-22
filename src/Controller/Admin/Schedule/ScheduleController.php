<?php

namespace App\Controller\Admin\Schedule;

use App\Entity\Doctor;
use App\Entity\Schedule;
use App\Form\ScheduleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/schedule/{doctorId}/create', name: 'app_schedule_create')]
    public function create(Request $request,EntityManagerInterface $entityManager, int $doctorId): Response
    {
        $doctor = $entityManager->getRepository(Doctor::class)->find($doctorId);
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
        ]);
    }

    #[Route('/schedules', name: 'app_schedule_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $schedules = $entityManager->getRepository(Schedule::class)->findAll();

        return $this->render('admin/Schedule/list.html.twig', [
            'schedules' => $schedules,
        ]);
    }
}
