<?php

namespace App\Controller;

use App\Entity\Prescription;
use App\Entity\Review;
use App\Entity\Stay;
use App\Entity\User;
use App\Repository\StayRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIController
{
    #[Route('/api/stays', name: 'get_all_stays', methods: ['GET'])]
    public function getAllStays(Request $request, UserRepository $userRepository, APIController $apiController): JsonResponse
    {
        // Ajout de logs pour le débogage
        error_log('getAllStays called');

        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_SECRETARY', $user->getRoles())) {
            error_log('Access denied: Invalid user or role');
            throw $this->createAccessDeniedException('Access denied');
        }

        // Récupérez la date d'aujourd'hui
        $today = new \DateTime();
        $today->setTime(0, 0, 0);

        // Récupérez tous les séjours qui commencent ou se terminent aujourd'hui
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('s')
            ->from(Stay::class, 's')
            ->where('s.startDate = :today')
            ->orWhere('s.endDate = :today')
            ->setParameter('today', $today);

        $stays = $qb->getQuery()->getResult();

        // Formatez les données des séjours
        $stayData = [];
        foreach ($stays as $stay) {
            $stayData[] = [
                'id' => $stay->getId(),
                'user_firstname' => $stay->getUser()->getFirstname(),
                'user_lastname' => $stay->getUser()->getLastname(),
                'specialty_id' => $stay->getSpecialty()->getId(),
                'reason' => $stay->getReason(),
                'start_date' => $stay->getStartDate()->format('Y-m-d'),
                'end_date' => $stay->getEndDate() ? $stay->getEndDate()->format('Y-m-d') : null,
            ];
        }

        return new JsonResponse($stayData, 200);
    }
}