<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Stay;
use App\Form\StayType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StayController extends AbstractController
{
    #[Route('/stay/create', name: 'app_stay_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stay = new Stay();
        $form = $this->createForm(StayType::class, $stay);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $stay->setUser($user);
            $entityManager->persist($stay);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('Stay/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/doctors/by-specialty/{specialtyId}', name: 'doctors_by_specialty', methods: ['GET'])]
    public function getDoctorsBySpecialty($specialtyId, EntityManagerInterface $entityManager): Response
    {
        $doctors = $entityManager->getRepository(Doctor::class)->findBy(['specialty' => $specialtyId]);

        $doctorData = [];
        foreach ($doctors as $doctor) {
            $doctorData[] = [
                'id' => $doctor->getId(),
                'firstname' => $doctor->getFirstname(),
                'lastname' => $doctor->getLastname(),
            ];
        }

        return $this->json(['doctors' => $doctorData]);
    }
}
