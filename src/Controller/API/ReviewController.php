<?php

namespace App\Controller\API;

use App\Entity\Review;
use App\Entity\Stay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class ReviewController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/review', name: 'add_review', methods: ['POST'])]
    public function addReview(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
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

        $existingReview = $entityManager->getRepository(Review::class)->findOneBy([
            'stay' => $stay,
            'date' => $today,
        ]);

        if ($existingReview) {
            return new JsonResponse(['error' => 'A review already exists for today.'], 400);
        }

        $review = new Review();
        $review->setStay($stay);
        $review->setDate($today);
        $review->setTitle($data['title']);
        $review->setDescription($data['description']);

        $errors = $validator->validate($review);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], 400);
        }

        $entityManager->persist($review);
        $entityManager->flush();

        $response = [
            'id' => $review->getId(),
            'title' => $review->getTitle(),
            'description' => $review->getDescription(),
            'date' => $review->getDate()->format('Y-m-d'),
            'stay_id' => $stay->getId(),
            'user_firstname' => $stay->getUser()->getFirstname(),
            'user_lastname' => $stay->getUser()->getLastname(),
        ];

        return new JsonResponse($response, 201);
    }

    #[Route('/review/check', name: 'check_review', methods: ['GET'])]
    public function checkReview(Request $request, EntityManagerInterface $entityManager): JsonResponse
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

        $review = $entityManager->getRepository(Review::class)->findOneBy([
            'stay' => $stayId,
            'date' => $today,
        ]);

        if ($review) {
            $response = [
                'exists' => true,
                'review' => [
                    'id' => $review->getId(),
                    'title' => $review->getTitle(),
                    'description' => $review->getDescription(),
                    'date' => $review->getDate()->format('Y-m-d'),
                    'user_firstname' => $review->getStay()->getUser()->getFirstname(),
                    'user_lastname' => $review->getStay()->getUser()->getLastname(),
                ],
            ];
            return new JsonResponse($response, 200);
        }

        return new JsonResponse(['exists' => false], 200);
    }

    #[Route('/review/{id}', name: 'get_review', methods: ['GET'])]
    public function getReview(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $review = $entityManager->getRepository(Review::class)->find($id);

        if (!$review) {
            return new JsonResponse(['error' => 'Review not found'], 404);
        }

        $data = [
            'id' => $review->getId(),
            'title' => $review->getTitle(),
            'description' => $review->getDescription(),
            'date' => $review->getDate()->format('Y-m-d'),
            'user_firstname' => $review->getStay()->getUser()->getFirstname(),
            'user_lastname' => $review->getStay()->getUser()->getLastname(),
        ];

        return new JsonResponse($data, 200);
    }
}
