<?php

namespace App\Repository;

use App\Entity\RoadTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoadTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadTrip[]    findAll()
 * @method RoadTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadTripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadTrip::class);
    }

    // /**
    //  * @return RoadTrip[] Returns an array of RoadTrip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoadTrip
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
