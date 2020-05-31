<?php

namespace App\Repository;

use App\Entity\Proposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposition[]    findAll()
 * @method Proposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proposition::class);
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDateBabySitting($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'Proposition faire du babysitting')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDatePharmacie($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'Proposition aller à la pharmacie')
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $date
     * @return int|mixed|string
     */
    public function findAllByDateCourse($date)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.createdAt <= :createdAt')
            ->setParameter('createdAt', $date)
            ->andWhere('d.type = :type')
            ->setParameter('type', 'Proposition aller faire des courses')
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
    public function findByProposition($type,$value)
    {

        return $this->createQueryBuilder('p')
            ->andwhere('p.type = :type')
            ->andWhere('p.city LIKE :city')
            ->orWhere('p.zip = :zip')
            ->andWhere('p.pays LIKE :pays')
            ->setParameters(['type'=> $type,'city'=>'%'.$value->getCity().'%', 'zip'=> '%'.$value->getZip().'%'
                             , 'pays'=>'%'.$value->getPays().'%'])
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPropositionPharmacie($city,$zip,$pays,$medic)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = :MEDIC')
            ->andWhere('p.zip LIKE :zip')
            ->orWhere('p.pays LIKE :pays')
            ->orWhere('p.city LIKE :city')
            ->setParameters(['city'=>'%'.$city.'%','pays' =>'%'.$pays.'%','zip' => '%'.$zip.'%','MEDIC'=>$medic])
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPropositionBabySitting($city,$zip,$pays,$baby)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = :BABYSITTING')
            ->andWhere('p.zip LIKE :zip')
            ->orWhere('p.pays LIKE :pays')
            ->orWhere('p.city LIKE :city')
            ->setParameters(['city'=>'%'.$city.'%','pays' =>'%'.$pays.'%','zip' => '%'.$zip.'%','BABYSITTING'=>$baby])
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return Proposition[] Returns an array of Proposition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Proposition
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
