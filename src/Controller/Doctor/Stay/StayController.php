<?php

namespace App\Controller\Doctor\Stay;

use App\Entity\Prescription;
use App\Entity\Stay;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
                'doctor_id' => $stay->getDoctor()->getId(),
                'user_id' => $stay->getUser()->getId(),
                'user_firstname' => $stay->getUser()->getFirstname(),
                'user_lastname' => $stay->getUser()->getLastname(),
                'reason' => $stay->getReason(),
                'start_date' => $stay->getStartDate()->format('Y-m-d'),
                'end_date' => $stay->getEndDate()->format('Y-m-d'),
            ];
        }

        return new JsonResponse($stayData, 200);
    }
}
