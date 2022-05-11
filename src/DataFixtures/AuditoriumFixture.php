<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Auditorium;

class AuditoriumFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aud = new Auditorium();
        $aud->setCountSeats('90');
        $aud->setNumber('2-255');
        $aud->setSquare('50.5');
        $manager->persist($aud);

        $manager->flush();
    }
}
