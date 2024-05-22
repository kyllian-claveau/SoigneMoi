<?php

// src/Controller/DoctorController.php

namespace App\Controller\Admin\Doctor;

use App\Entity\Doctor;
use App\Form\DoctorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class DoctorController extends AbstractController
{
    #[Route('/doctor/create', name: 'app_doctor_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $doctor = new Doctor();
        $form = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($doctor);
            $entityManager->flush();

            $this->addFlash('success', 'Le médecin a été créé avec succès.');

            return $this->redirectToRoute('app_doctor_list');
        }

        return $this->render('admin/Doctor/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/doctor/list', name: 'app_doctor_list')]
    public function list(EntityManagerInterface $entityManager)
    {
        $doctors = $entityManager->getRepository(Doctor::class)->findAll();
        return $this->render('admin/Doctor/list.html.twig', [
            'doctors' => $doctors,
        ]);
    }
}
