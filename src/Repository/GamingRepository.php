<?php

namespace App\Repository;

use App\Entity\Gaming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gaming|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gaming|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gaming[]    findAll()
 * @method Gaming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gaming::class);
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDate($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Gaming[] Returns an array of Gaming objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gaming
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
