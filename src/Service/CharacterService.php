<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function create() {
        $character = new character();
        $character
        ->setKind('lord')
        ->setName('Nolofinwe')
        ->setSurname('Sagesse')
        ->setCaste('Chevalier')
        ->setKnowledge('Diplomatie')
        ->setIntelligence(110)
        ->setLife(13)
        ->setImage('/images/Nolofinwe.jpg')
        ->setCreation(new \DateTime())
    ;
    $this->em->persist($character);
    $this->em->flush();
    return $character;
    }
}