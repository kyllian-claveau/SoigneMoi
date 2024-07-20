<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

class indexController extends AbstractController
{
    #[Route("/", name: "app_index")]
    public function index(Request $request, UserRepository $userRepository, APIController $apiController)
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user instanceof User) {
            $user = new User(); // Crée un utilisateur vide
            $user->setRoles(['']);
        }
        return $this->render('public/index.html.twig', [
            'user' => $user,
        ]);
    }
}