<?php

namespace App\Controller\API;

use App\Entity\Prescription;
use App\Entity\Stay;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class PrescriptionController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/prescription', name: 'add_prescription', methods: ['POST'])]
    public function addPrescription(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['stay_id'])) {
            return new JsonResponse(['error' => 'Missing stay_id'], 400);
        }

        $stay = $entityManager->getRepository(Stay::class)->find($data['stay_id']);
        if (!$stay) {
            return new JsonResponse(['error' => 'Stay not found'], 404);
        }

        $now = new \DateTime();
        $today = new \DateTime();
        $today->setTime(10, 0);

        if ($now < $today) {
            $today->modify('-1 day');
        }

        $existingPrescription = $entityManager->getRepository(Prescription::class)->findOneBy([
            'stay' => $stay,
            'date' => $today,
        ]);

        if ($existingPrescription) {
            return new JsonResponse(['error' => 'A prescription already exists for today.'], 400);
        }

        $prescription = new Prescription();
        $prescription->setStay($stay);
        $prescription->setDate($today);

        if (isset($data['start_date'])) {
            $prescription->setStartDate(new \DateTime($data['start_date']));
        }
        if (isset($data['end_date'])) {
            $prescription->setEndDate(new \DateTime($data['end_date']));
        }

        foreach ($data['medications'] as $medication) {
            $prescription->addMedication(
                $medication['name'],
                $medication['dosage']
            );
        }

        $errors = $validator->validate($prescription);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], 400);
        }

        $entityManager->persist($prescription);
        $entityManager->flush();

        $response = [
            'id' => $prescription->getId(),
            'start_date' => $prescription->getStartDate()->format('Y-m-d'),
            'end_date' => $prescription->getEndDate()->format('Y-m-d'),
            'stay_id' => $stay->getId(),
            'medications' => array_map(function ($med) {
                return ['name' => $med['name'], 'dosage' => $med['dosage']];
            }, $prescription->getMedications())
        ];

        return new JsonResponse($response, 201);
    }

    #[Route('/prescription/check', name: 'check_prescription', methods: ['GET'])]
    public function checkPrescription(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $stayId = $request->query->get('stay_id');

        if (!$stayId) {
            return new JsonResponse(['error' => 'Missing stay_id'], 400);
        }

        $now = new \DateTime();
        $today = new \DateTime();
        $today->setTime(10, 0);

        if ($now < $today) {
            $today->modify('-1 day');
        }

        $prescription = $entityManager->getRepository(Prescription::class)->findOneBy([
            'stay' => $stayId,
            'date' => $today,
        ]);

        if ($prescription) {
            return new JsonResponse(['exists' => true, 'prescription' => $prescription->getId()], 200);
        }

        return new JsonResponse(['exists' => false], 200);
    }

    #[Route('/prescription/{id}', name: 'get_prescription', methods: ['GET'])]
    public function getPrescription(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $prescription = $entityManager->getRepository(Prescription::class)->find($id);

        if (!$prescription) {
            return new JsonResponse(['error' => 'Prescription not found'], 404);
        }

        $data = [
            'id' => $prescription->getId(),
            'start_date' => $prescription->getStartDate()->format('Y-m-d'),
            'end_date' => $prescription->getEndDate()->format('Y-m-d'),
            'medications' => $prescription->getMedications(),
        ];

        return new JsonResponse($data, 200);
    }
    #[Route('/prescription/{id}', name: 'update_prescription', methods: ['PUT'])]
    public function updatePrescription(int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse {
        $prescription = $entityManager->getRepository(Prescription::class)->find($id);

        if (!$prescription) {
            return new JsonResponse(['error' => 'Prescription not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['end_date'])) {
            try {
                $endDate = new \DateTime($data['end_date']);
                $prescription->setEndDate($endDate);
                $entityManager->flush();

                return new JsonResponse(['message' => 'Prescription updated successfully'], 200);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => 'Invalid date format'], 400);
            }
        }

        return new JsonResponse(['error' => 'End date not provided'], 400);
    }
}