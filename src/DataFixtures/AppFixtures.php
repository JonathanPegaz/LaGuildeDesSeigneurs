<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $character = new Character();
            $character
            ->setKind(rand(0, 1) ? 'Dame' : 'Seigneur')
            ->setName('Eldalótë' . $i)
            ->setSurname('Fleur elfique')
            ->setCaste('Elfe')
            ->setKnowledge('Arts')
            ->setIntelligence(mt_rand(100, 200))
            ->setLife(mt_rand(10, 20))
            ->setImage('/images/eldalote.jpg')
            ->setIdentifier(hash('sha1', uniqid()))
            ->setCreation(new DateTime())
            ->setModification(new \DateTime())
            ;
            $manager->persist($character);
        }
        for ($i = 0; $i < 2; $i++) {
            $player = new Player();
            $player
            ->setFirstname('Jojo')
            ->setLastname('Pegaz')
            ->setEmail('pegazjonathan@gmail.com')
            ->setMirian(10)
            ->setCreation(new \DateTime())
            ->setModification(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ;
            $manager->persist($player);
        }
        $manager->flush();
    }
}
