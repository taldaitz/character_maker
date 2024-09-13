<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CharacterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $character = new Character();
        $character->setName('Sangoku')
                ->setHealth(500)
                ->setStrength(56)
                ->setConstitution(64)
                ->setIntelligence(12)
                ->setAgility(45)
                ->setJob('Warrior')
                ->setWins(17)
                ->setLooses(0)
        ;


        $vegeta = new Character();
        $vegeta->setName('Vegeta')
                ->setHealth(400)
                ->setStrength(52)
                ->setConstitution(64)
                ->setIntelligence(21)
                ->setAgility(49)
                ->setJob('Warrior')
                ->setWins(16)
                ->setLooses(1)
        ;

        $manager->persist($character);
        $manager->persist($vegeta);
        $manager->flush();
    }
}
