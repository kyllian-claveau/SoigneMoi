<?php

namespace App\Tests\Service;

use App\Entity\Schedule;
use App\Entity\Specialty;
use App\Entity\Stay;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class StayServiceTest extends TestCase
{
    public function testCreateStay()
    {
        $patient = new User();
        $patient->setId(5); // Assurez-vous que votre entité User a une méthode setId()

        $doctor = new User();
        $doctor->setId(7); // Assurez-vous que votre entité User a une méthode setId()

        $specialty = new Specialty();
        $specialty->setId(2); // Assurez-vous que votre entité Specialty a une méthode setId()

        $schedule = new Schedule();
        $schedule->setId(1); // Assurez-vous que votre entité Schedule a une méthode setDoctor()

        $stay = new Stay();
        $stay->setStartDate(new \DateTime('2024-08-01'));
        $stay->setEndDate(new \DateTime('2024-08-15'));
        $stay->setDoctor($doctor);
        $stay->setUser($patient);
        $stay->setSchedule($schedule);
        $stay->setSpecialty($specialty);
        $stay->setReason('Mal de jambes');

        $this->assertEquals($patient, $stay->getUser());
        $this->assertEquals($doctor, $stay->getDoctor());
        $this->assertEquals('2024-08-01', $stay->getStartDate()->format('Y-m-d'));
        $this->assertEquals('2024-08-15', $stay->getEndDate()->format('Y-m-d'));
        $this->assertEquals($schedule, $stay->getSchedule());
        $this->assertEquals($specialty, $stay->getSpecialty());
        $this->assertEquals('Mal de jambes', $stay->getReason());
    }
}
