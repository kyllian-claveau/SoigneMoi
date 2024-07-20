<?php

namespace App\Controller\User\Dashboard;

use App\Controller\APIController;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
#[Route('/dashboard', name: 'app_user_dashboard')]
    public function index(Request $request, UserRepository $userRepository, APIController $apiController): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        return $this->render('user/Dashboard/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}