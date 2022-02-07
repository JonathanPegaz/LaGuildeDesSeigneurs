<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;

class CharacterService implements CharacterServiceInterface
{
    private $characterRepository;
    private $em;
    
    public function __construct(EntityManagerInterface $em, CharacterRepository $characterRepository)
    {
        $this->characterRepository = $characterRepository;
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
        ->setIdentifier(hash('sha1', uniqid()))
    ;
    $this->em->persist($character);
    $this->em->flush();
    return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll() {
        $charactersFinal = array();
        $characters = $this->characterRepository->findAll();
        foreach ($characters as $character) {
            $charactersFinal[] = $character->toArray();
        }
        return $charactersFinal;
    }
}