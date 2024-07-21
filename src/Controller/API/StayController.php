<?php

namespace App\Controller\API;

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
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class StayController extends AbstractController
{
    private $entityManager;
    private $security;
    private $logger;

    private $jwtEncoder;

    public function __construct(EntityManagerInterface $entityManager, Security $security,JWTEncoderInterface $jwtEncoder, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->jwtEncoder = $jwtEncoder;
    }

    #[Route('/api/stays', name: 'get_all_stays', methods: ['POST'])]
    public function getAllStays(Request $request, UserRepository $userRepository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $token = $content['token'] ?? null;

        if (!$token) {
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        // Décoder le token
        $token = str_replace('Bearer ', '', $token); // Enlever 'Bearer ' du token s'il est présent
        $decodedToken = $this->jwtEncoder->decode($token);

        if (!$decodedToken) {
            return new JsonResponse(['message' => 'Invalid token.'], 401);
        }

        // Extraire l'identifiant de l'utilisateur depuis le token
        $userId = $decodedToken['id'];

        // Récupérer l'utilisateur depuis la base de données
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        // Récupérer la date d'aujourd'hui
        $today = new \DateTime();
        $today->setTime(0, 0, 0);

        // Récupérer tous les séjours qui commencent ou se terminent aujourd'hui
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('s')
            ->from(Stay::class, 's')
            ->where('s.startDate = :today')
            ->orWhere('s.endDate = :today')
            ->setParameter('today', $today);

        $stays = $qb->getQuery()->getResult();

        // Formater les données des séjours
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


    #[Route('/api/stays/{id}/details', name: 'get_stay_details', methods: ['POST'])]
    public function getStayDetails(int $id, Request $request, UserRepository $userRepository): JsonResponse
    {
        $this->logger->info('Fetching stay details for ID: ' . $id);

        $content = json_decode($request->getContent(), true);
        $token = $content['token'] ?? null;

        if (!$token) {
            $this->logger->error('Invalid credentials');
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        // Décoder le token
        $decodedToken = $this->jwtEncoder->decode($token);

        if (!$decodedToken) {
            $this->logger->error('Invalid token');
            return new JsonResponse(['message' => 'Invalid token.'], 401);
        }

        // Extraire l'identifiant de l'utilisateur depuis le token
        $userId = $decodedToken['id'];

        // Récupérer l'utilisateur depuis la base de données
        $user = $userRepository->find($userId);

        if (!$user) {
            $this->logger->error('User not found for ID: ' . $userId);
            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        // Récupérer les détails du séjour
        $stay = $this->entityManager->getRepository(Stay::class)->find($id);
        if (!$stay) {
            $this->logger->error('Stay not found for ID: ' . $id);
            return new JsonResponse(['message' => 'Stay not found'], 404);
        }

        // Récupérer les prescriptions et les avis
        $prescriptions = $this->entityManager->getRepository(Prescription::class)->findBy(['stay' => $id], ['date' => 'ASC']);
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['stay' => $id], ['date' => 'ASC']);

        $this->logger->info('Prescriptions and Reviews retrieved.');

        // Formater les données des prescriptions
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

        // Formater les données des avis
        $reviewData = [];
        foreach ($reviews as $review) {
            $reviewData[] = [
                'id' => $review->getId(),
                'title' => $review->getTitle(),
                'date' => $review->getDate()->format('Y-m-d'),
                'description' => $review->getDescription(),
            ];
        }

        // Formater les données du séjour
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
