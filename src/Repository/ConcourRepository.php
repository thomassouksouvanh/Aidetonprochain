<?php

namespace App\Repository;

use App\Entity\Concour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concour[]    findAll()
 * @method Concour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concour::class);
    }

    // /**
    //  * @return Concour[] Returns an array of Concour objects
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
    public function findOneBySomeField($value): ?Concour
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
