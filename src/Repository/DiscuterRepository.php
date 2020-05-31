<?php

namespace App\Repository;

use App\Entity\Discuter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discuter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discuter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discuter[]    findAll()
 * @method Discuter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscuterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discuter::class);
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

    /**
     * @param $value
     * @return int|mixed|string
     */
    public function findBySujetDiscution($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.sujet LIKE :sujet')
            ->setParameter('sujet', '%'.$value->getSujet().'%')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Discuter[] Returns an array of Discuter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discuter
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
