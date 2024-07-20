<?php

namespace App\Controller\Admin\Dashboard;

use App\Controller\APIController;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class DashboardController extends AbstractController
{
#[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(Request $request, UserRepository $userRepository, APIController $apiController): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        return $this->render('Admin/Dashboard/dashboard.html.twig', [
            'user' => $user,
        ]);
    }


}