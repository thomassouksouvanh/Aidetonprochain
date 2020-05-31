<?php

namespace App\Repository;

use App\Entity\Streaming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Streaming|null find($id, $lockMode = null, $lockVersion = null)
 * @method Streaming|null findOneBy(array $criteria, array $orderBy = null)
 * @method Streaming[]    findAll()
 * @method Streaming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Streaming::class);
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
    //  * @return Streaming[] Returns an array of Streaming objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Streaming
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
