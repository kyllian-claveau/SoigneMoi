<?php

namespace App\Controller\Admin\Specialty;

use App\Controller\APIController;
use App\Entity\Specialty;
use App\Form\SpecialtyType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class SpecialtyController extends AbstractController
{
    #[Route('/specialty/create', name: 'app_specialty_create')]
    public function createRequest (Request $request, UserRepository $userRepository, APIController $apiController, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        $specialty = new Specialty();
        $form = $this->createForm(SpecialtyType::class, $specialty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($specialty);
            $entityManager->flush();

            $this->addFlash('success', 'La spécialité a été créé avec succès.');

            return $this->redirectToRoute('app_specialty_list');
        }

        return $this->render('admin/Specialty/create.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/specialty/list', name: 'app_specialty_list')]
    public function list(Request $request, UserRepository $userRepository, APIController $apiController,EntityManagerInterface $entityManager)
    {
        $user = $apiController->getUserFromToken($request, $userRepository);
        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }
        $specialtys = $entityManager->getRepository(Specialty::class)->findAll();
        return $this->render('admin/Specialty/list.html.twig', [
            'specialtys' => $specialtys,
            'user' => $user,
        ]);
    }
}
