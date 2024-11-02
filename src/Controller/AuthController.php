<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthController extends AbstractController
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(Request $request, AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            $token = $this->jwtManager->create($user);

            return new JsonResponse([
                'message' => 'Authentification réussie',
                'token' => $token,
            ], JsonResponse::HTTP_OK);
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error instanceof AuthenticationException) {
            return new JsonResponse([
                'message' => 'Identifiants invalides',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'message' => 'Erreur lors de la connexion',
        ], JsonResponse::HTTP_BAD_REQUEST);
    }


    #[Route(path: '/login', name: 'app_login', methods: ['GET'])]
    public function login(Request $request, UserRepository $userRepository, APIController $apiController): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);

        if ($user instanceof User && $user->getId()) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('public/Auth/login.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): Response
    {
        $response = $this->redirectToRoute('app_index');
        $response->headers->clearCookie('authToken');
        return $response;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserRepository $userRepository, APIController $apiController, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $apiController->getUserFromToken($request, $userRepository);

        if ($user instanceof User && $user->getId()) {
            return $this->redirectToRoute('app_index');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        // Checking if the user exists in the token
        $existingUser = $apiController->getUserFromToken($request, $userRepository);
        if ($existingUser instanceof User) {
            $user = $existingUser;
        } else {
            $user = new User(); // Create a new empty user
            $user->setRoles(['']);
        }

        return $this->render('public/Auth/register.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
