<?php

namespace App\Controller\API;

use App\Controller\APIController;
use App\Entity\Prescription;
use App\Entity\Review;
use App\Entity\Stay;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Psr\Log\LoggerInterface;

class StayController extends AbstractController
{
    private $entityManager;
    private $security;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, Security $security, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
    }

    #[Route('/api/stays', name: 'get_all_stays', methods: ['GET'])]
    public function getAllStays(Request $request, UserRepository $userRepository, APIController $apiController): JsonResponse
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_SECRETARY', $user->getRoles())) {
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


    #[Route('/api/stays/{id}/details', name: 'get_stay_details', methods: ['GET'])]
    public function getStayDetails(int $id): JsonResponse
    {
        $this->logger->info('Fetching stay details for ID: ' . $id);

        // Vérifiez que l'utilisateur est authentifié
        $user = $this->security->getUser();
        if (!$user) {
            $this->logger->error('Invalid credentials');
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        // Récupérez les détails du séjour
        $stay = $this->entityManager->getRepository(Stay::class)->find($id);
        if (!$stay) {
            $this->logger->error('Stay not found for ID: ' . $id);
            return new JsonResponse(['message' => 'Stay not found'], 404);
        }

        // Récupérez les prescriptions et les avis
        $prescriptions = $this->entityManager->getRepository(Prescription::class)->findBy(['stay' => $id], ['date' => 'ASC']);
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['stay' => $id], ['date' => 'ASC']);

        $this->logger->info('Prescriptions and Reviews retrieved.');

        // Formatez les données des prescriptions
        $prescriptionData = [];
        foreach ($prescriptions as $prescription) {
            $medications = $prescription->getMedications();
            if (is_string($medications)) {
                $medications = json_decode($medications, true);
            }
            $prescriptionData[] = [
                'id' => $prescription->getId(),
                'date' => $prescription->getDate()->format('Y-m-d'),
                'start_date' => $prescription->getStartDate()->format('Y-m-d'),
                'end_date' => $prescription->getEndDate()->format('Y-m-d'),
                'medications' => $medications,
            ];
        }

        // Formatez les données des avis
        $reviewData = [];
        foreach ($reviews as $review) {
            $reviewData[] = [
                'id' => $review->getId(),
                'title' => $review->getTitle(),
                'date' => $review->getDate()->format('Y-m-d'),
                'description' => $review->getDescription(),
            ];
        }

        // Formatez les données du séjour
        $stayData = [
            'id' => $stay->getId(),
            'user_firstname' => $stay->getUser()->getFirstname(),
            'user_lastname' => $stay->getUser()->getLastname(),
            'specialty_id' => $stay->getSpecialty()->getId(),
            'reason' => $stay->getReason(),
            'start_date' => $stay->getStartDate()->format('Y-m-d'),
            'end_date' => $stay->getEndDate() ? $stay->getEndDate()->format('Y-m-d') : null,
            'prescriptions' => $prescriptionData,
            'reviews' => $reviewData,
        ];

        $this->logger->info('Stay details formatted successfully for ID: ' . $id);

        return new JsonResponse($stayData, 200);
    }
}
