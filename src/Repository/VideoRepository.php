<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDateFlashMob($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'FLASHMOB')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDateStorie($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'STORIES')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDateChallenge($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'CHALLENGE')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUser($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.id = :id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
