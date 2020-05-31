<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\HavingClause;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
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
    public function findByMatiereFormation($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.matiere LIKE :matiere')
            ->setParameter('matiere', '%'.$value.'%')
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Formation[] Returns an array of Formation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
