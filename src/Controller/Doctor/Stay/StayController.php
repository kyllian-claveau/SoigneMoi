<?php

namespace App\Controller\Doctor\Stay;

use App\Entity\Stay;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class StayController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/doctor/{id}/stays', name: 'app_stay_doctor_list', methods: ['GET'])]
    public function list(int $id): JsonResponse
    {
        $user = $this->security->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        if ($user->getId() !== $id) {
            return new JsonResponse(['message' => 'You do not have access to this resource.'], 403);
        }

        $stays = $this->entityManager->getRepository(Stay::class)->findBy(['doctor' => $id]);

        $stayData = [];
        foreach ($stays as $stay) {
            $stayData[] = [
                'id' => $stay->getId(),
                'specialty_id' => $stay->getSpecialty()->getId(),
                'doctor_id' => $stay->getDoctor()->getId(),
                'user_id' => $stay->getUser()->getId(),
                'reason' => $stay->getReason(),
                'schedule_id' => $stay->getSchedule()->getId(),
            ];
        }

        return new JsonResponse($stayData, 200);
    }
}
