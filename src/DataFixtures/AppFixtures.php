<?php

namespace App\DataFixtures;

use App\Entity\Schedule;
use App\Entity\Specialty;
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
        // Création d'une spécialité Dentiste
        $specialty1 = new Specialty();
        $specialty1->setName("Dentiste");
        $manager->persist($specialty1);

        // Création d'une spécialité Généraliste
        $specialty2 = new Specialty();
        $specialty2->setName("Généraliste");
        $manager->persist($specialty2);

        // Création d'un user "patient"
        $user = new User();
        $user->setEmail("user@soignemoi.com");
        $user->setFirstname("Jane");
        $user->setLastname("Doe");
        $user->setAddress("1 rue de la paix");
        $user->setCity("Paris");
        $user->setPostalCode(75000);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "iamapatientpassword"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@soignemoi.com");
        $userAdmin->setFirstname("John");
        $userAdmin->setLastname("Doe");
        $userAdmin->setAddress("1 rue de la paix");
        $userAdmin->setCity("Paris");
        $userAdmin->setPostalCode(75000);
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "iamanadminpassword"));
        $manager->persist($userAdmin);

        // Création d'un docteur
        $doctor1 = new User();
        $doctor1->setEmail("doctor1@soignemoi.com");
        $doctor1->setFirstname("Jean");
        $doctor1->setLastname("Dupont");
        $doctor1->setAddress("1 rue de la paix");
        $doctor1->setCity("Paris");
        $doctor1->setPostalCode(75000);
        $doctor1->setSpecialty($specialty1);
        $doctor1->setRoles(["ROLE_DOCTOR"]);
        $doctor1->setMatricule("654321");
        $doctor1->setPassword($this->userPasswordHasher->hashPassword($doctor1, "iamadoctor1password"));
        $manager->persist($doctor1);

        // Création d'un emploi du temps pour le docteur1
        $schedule1 = new Schedule();
        $schedule1->setDoctor($doctor1);
        $manager->persist($schedule1);

        // Création d'un docteur
        $doctor2 = new User();
        $doctor2->setEmail("doctor2@soignemoi.com");
        $doctor2->setFirstname("Janette");
        $doctor2->setLastname("Martin");
        $doctor2->setAddress("1 rue de la paix");
        $doctor2->setCity("Paris");
        $doctor2->setPostalCode(75000);
        $doctor2->setSpecialty($specialty2);
        $doctor2->setRoles(["ROLE_DOCTOR"]);
        $doctor2->setMatricule("123456");
        $doctor2->setPassword($this->userPasswordHasher->hashPassword($doctor2, "iamadoctor2password"));
        $manager->persist($doctor2);

        // Création d'un emploi du temps pour le docteur2
        $schedule2 = new Schedule();
        $schedule2->setDoctor($doctor2);
        $manager->persist($schedule2);

        // Création d'un secrétaire
        $secretary = new User();
        $secretary->setEmail("secretary@soignemoi.com");
        $secretary->setFirstname("Jane");
        $secretary->setLastname("Dupont");
        $secretary->setAddress("1 rue de la paix");
        $secretary->setCity("Paris");
        $secretary->setPostalCode(75000);
        $secretary->setRoles(["ROLE_SECRETARY"]);
        $secretary->setPassword($this->userPasswordHasher->hashPassword($secretary, "iamasecretarypassword"));
        $manager->persist($secretary);

        $manager->flush();
    }
}