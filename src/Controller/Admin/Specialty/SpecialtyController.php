<?php

namespace App\Controller\Admin\Specialty;

use App\Entity\Specialty;
use App\Form\SpecialtyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class SpecialtyController extends AbstractController
{
    #[Route('/specialty/create', name: 'app_specialty_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
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
        ]);
    }

    #[Route('/specialty/list', name: 'app_specialty_list')]
    public function list(EntityManagerInterface $entityManager)
    {
        $specialtys = $entityManager->getRepository(Specialty::class)->findAll();
        return $this->render('admin/Specialty/list.html.twig', [
            'specialtys' => $specialtys,
        ]);
    }
}
