<?php

namespace App\Controller\User\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class DashboardController extends AbstractController
{
#[Route('/dashboard', name: 'app_user_dashboard')]
    public function index(): Response
    {
        return $this->render('User/Dashboard/dashboard.html.twig');
    }
}