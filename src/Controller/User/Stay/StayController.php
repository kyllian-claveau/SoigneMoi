<?php

namespace App\Controller\User\Stay;

use App\Controller\APIController;
use App\Entity\Stay;
use App\Entity\User;
use App\Form\StayType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StayController extends AbstractController
{
    #[Route('/stay/create', name: 'app_stay_create')]
    public function create(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        $stay = new Stay();
        $form = $this->createForm(StayType::class, $stay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = $stay->getStartDate()->format('Y-m-d');
            $endDate = $stay->getEndDate()->format('Y-m-d');

            $staysForDate = $entityManager->getRepository(Stay::class)->findByDateRange($startDate, $endDate);
            $staysForDateUser = $entityManager->getRepository(Stay::class)->findByDateRangeByUser($startDate, $endDate, $user->getId());

            // Limiter le nombre de séjours à un maximum de 5 && un seul séjour par user par jour
            if ((count($staysForDate) >= 5) || (count($staysForDateUser) >= 1)) {
                $this->addFlash('error', 'Le nombre maximum de séjours pour cette date a été atteint ou vous avez déjà un séjour dans cette plage de dates.');
                return $this->redirectToRoute('app_stay_create');
            }

            $stay->setUser($user);

            $doctor = $stay->getDoctor();
            $schedule = $doctor->getSchedule();
            $stay->setSchedule($schedule);

            $entityManager->persist($stay);
            $entityManager->flush();

            $this->addFlash('success', 'Le séjour a été créé avec succès.');

            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->render('public/Stay/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/user/stay/list/over', name: 'app_stay_list_over')]
    public function listOver(Request $request, UserRepository $userRepository, APIController $apiController,EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_USER', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        // Récupérer les séjours passés
        $currentDate = new \DateTime();
        $stays = $entityManager->getRepository(Stay::class)->createQueryBuilder('s')
            ->where('s.user = :user')
            ->andWhere('s.endDate < :currentDate')
            ->setParameter('user', $user)
            ->setParameter('currentDate', $currentDate)
            ->getQuery()
            ->getResult();

        return $this->render('user/Stay/listOver.html.twig', [
            'stays' => $stays,
            'user' => $user,
        ]);
    }

    #[Route('/user/stay/list/now', name: 'app_stay_list_now')]
    public function listNow(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_USER', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        // Récupérer les séjours en cours
        $currentDate = new \DateTime();
        $stays = $entityManager->getRepository(Stay::class)->createQueryBuilder('s')
            ->where('s.user = :user')
            ->andWhere('s.startDate <= :currentDate')
            ->andWhere('s.endDate >= :currentDate')
            ->setParameter('user', $user)
            ->setParameter('currentDate', $currentDate)
            ->getQuery()
            ->getResult();

        return $this->render('user/Stay/listNow.html.twig', [
            'stays' => $stays,
            'user' => $user,
        ]);
    }

    #[Route('/user/stay/list/coming-soon', name: 'app_stay_list_coming_soon')]
    public function listComingSoon(Request $request, UserRepository $userRepository, APIController $apiController,EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_USER', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
        $currentDate = new \DateTime();
        $stays = $entityManager->getRepository(Stay::class)->createQueryBuilder('s')
            ->where('s.user = :user')
            ->andWhere('s.startDate > :currentDate')
            ->setParameter('user', $user)
            ->setParameter('currentDate', $currentDate)
            ->getQuery()
            ->getResult();

        return $this->render('user/Stay/listComingSoon.html.twig', [
            'stays' => $stays,
            'user' => $user,
        ]);
    }



    #[Route('/doctors/by-specialty/{specialtyId}', name: 'doctors_by_specialty', methods: ['GET'])]
    public function getDoctorsBySpecialty(Request $request, UserRepository $userRepository, APIController $apiController, $specialtyId, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        $doctors = $entityManager->getRepository(User::class)->findBy(['specialty' => $specialtyId]);
        if (!$user || !in_array('ROLE_USER', $user->getRoles())) {
            throw $this->createAccessDeniedException('Access denied');
        }
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
