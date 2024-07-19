<?php
// src\DataFixtures\AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un user "normal"
        $user = new User();
        $user->setEmail("user@soignemoi.com");
        $user->setFirstname("John");
        $user->setLastname("Doe");
        $user->setAddress("1 rue de la paix");
        $user->setCity("Paris");
        $user->setPostalCode(75000);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "passwordUser"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@soignemoi.com");
        $userAdmin->setFirstname("Jane");
        $userAdmin->setLastname("Doe");
        $userAdmin->setAddress("1 rue de la paix");
        $userAdmin->setCity("Paris");
        $userAdmin->setPostalCode(75000);
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "passwordAdmin"));
        $manager->persist($userAdmin);

        $manager->flush();
    }
}