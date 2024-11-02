<?php

namespace App\Controller\Secretary\Dashboard;

use App\Controller\APIController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/secretary')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_secretary_dashboard')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_SECRETARY', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('secretary/Dashboard/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}