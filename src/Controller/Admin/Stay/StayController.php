<?php

namespace App\Controller\Admin\Stay;

use App\Controller\APIController;
use App\Entity\Stay;
use App\Form\StayType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]
class StayController extends AbstractController
{
    #[Route('/stay', name: 'app_stay_admin_list')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController,EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        $stays = $entityManager->getRepository(Stay::class)->findAll();

        return $this->render('Admin/Stay/list.html.twig', [
            'stays' => $stays,
            'user' => $user,
        ]);
    }
}
