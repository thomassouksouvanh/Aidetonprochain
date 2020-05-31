<?php

namespace App\Repository;

use App\Entity\Information;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Information|null find($id, $lockMode = null, $lockVersion = null)
 * @method Information|null findOneBy(array $criteria, array $orderBy = null)
 * @method Information[]    findAll()
 * @method Information[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Information::class);
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
    public function findBySujetInformation($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.sujet LIKE :sujet')
            ->setParameter('sujet', '%'.$value.'%')
            ->orderBy('i.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Information[] Returns an array of Information objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Information
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
