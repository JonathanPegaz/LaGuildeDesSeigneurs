<?php

namespace App\Service;

use DateTime;
use App\Entity\Character;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;

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
        ->setModification(new \DateTime())
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

    /**
    * {@inheritdoc}
    */
    public function modify(Character $character)
    {
        $character
        ->setKind('Seigneur')
        ->setName('Gorthol')
        ->setSurname('Haume de terreur')
        ->setCaste('Chevalier')
        ->setKnowledge('Diplomatie')
        ->setIntelligence(110)
        ->setLife(13)
        ->setImage('/images/gorthol.jpg')
        ->setModification(new \DateTime())
        ;
        $this->em->persist($character);
        $this->em->flush();
        return $character;
    }

    /**
    * {@inheritdoc}
    */
    public function delete(Character $character)
    {
        $this->em->remove($character);
        $this->em->flush();
        return true;
    }

    public function getImages(int $number, ?string $kind = null)
    {
        $folder = __DIR__ . '/../../public/images/';
        $finder = new Finder();
        $finder
        ->files()
        ->in($folder)
        ->notPath('/cartes/')
        ->sortByName()
        ;
        if (null !== $kind) {
            $finder->path('/' . $kind . '/');
        }
        $images = array();
        foreach ($finder as $file) {
            $images[] = '/images/' . $file->getPathname();
        }
        shuffle($images);
        return array_slice($images, 0, $number, true);
    }
    public function getImagesKind(string $kind, int $number)
    {
        return $this->getImages($number, $kind);
    }
}