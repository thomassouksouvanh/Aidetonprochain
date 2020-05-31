<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * @param $date
     * @return int|mixed|string
     * Retourne un tableau de toutes les annonces babysitting par date
     */
    public function findAllByDateBabySitting($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->andWhere('d.type = :type')
            ->setParameter('createdAt', $date)
            ->setParameter('type', 'Annonce faire du babysitting')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     * Retourne un tableau de toutes les annonces pharmacie par date
     */
    public function findAllByDatePharmacie($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->andWhere('d.type = :type')
            ->setParameter('createdAt', $date)
            ->setParameter('type', 'Annonce aller à la pharmacie')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     * Retourne un tableau de toutes les annonces courses par date
     */
    public function findAllByDateCourse($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->andWhere('d.type = :type')
            ->setParameter('createdAt', $date)
            ->setParameter('type', 'Annonce aller faire des courses')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * return un tableau des proposition des courses filtrer par ville code postal et pays
     * @param $type
     * @param $value
     * @return int|mixed|string
     */
    public function findByAnnonce($type,$value)
    {

        return $this->createQueryBuilder('a')
            ->andwhere('a.type = :type')
            ->andWhere('a.city LIKE :city')
            ->orWhere('a.zip = :zip')
            ->andWhere('a.pays LIKE :pays')
            ->setParameters(['type'=>$type,'city'=>'%'.$value->getCity().'%','zip'=> '%'.$value->getZip().'%'
                             ,'pays'=>'%'.$value->getPays().'%'])
            ->orderBy('a.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
