<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "app_contact")]
    public function contact(Request $request, UserRepository $userRepository, APIController $apiController)
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        return $this->render('public/contact.html.twig', [
            'user' => $user,
        ]);
    }
}