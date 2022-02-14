<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService implements PlayerServiceInterface
{
    private $playerRepository;
    private $em;
    
    public function __construct(EntityManagerInterface $em, PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function create() {
        $player = new player();
        $player
        ->setFirstname('Jojo')
        ->setLastname('Pegaz')
        ->setEmail('pegazjonathan@gmail.com')
        ->setMirian(10)
        ->setCreation(new \DateTime())
        ->setModification(new \DateTime())
        ->setIdentifier(hash('sha1', uniqid()))
    ;
    $this->em->persist($player);
    $this->em->flush();
    return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll() {
        $playersFinal = array();
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }
        return $playersFinal;
    }

    /**
    * {@inheritdoc}
    */
    public function modify(Player $player)
    {
        $player
        ->setFirstname('Jerem')
        ->setLastname('keke')
        ->setEmail('kekejerem@gmail.com')
        ->setMirian(5)
        ->setModification(new \DateTime())
        ;
        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }

    /**
    * {@inheritdoc}
    */
    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();
        return true;
    }

}