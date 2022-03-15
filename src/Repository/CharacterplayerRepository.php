<?php

namespace App\Repository;

use App\Entity\Characterplayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Characterplayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characterplayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characterplayer[]    findAll()
 * @method Characterplayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterplayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characterplayer::class);
    }

    public function findOneByIdentifier($identifier)
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'p')
            ->leftJoin('c.player', 'p')
            ->where('c.identifier = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return Characterplayer[] Returns an array of Characterplayer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characterplayer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
