<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
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
    public function findByEntreprise($value)
    {
        return $this->createQueryBuilder('e')
            ->orWhere('e.nom LIKE :nom')
            ->orWhere('e.pays LIKE :pays')
            ->andWhere('e.city LIKE :city')
            ->setParameters(['nom' => '%'.$value->getName().'%','city'=>'%'.$value->getCity().'%', 'pays' =>'%'.$value->getPays().'%'])
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Entreprise[] Returns an array of Entreprise objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entreprise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
