<?php

namespace App\Repository;

use App\Entity\MeasurmentUnits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MeasurmentUnits|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeasurmentUnits|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeasurmentUnits[]    findAll()
 * @method MeasurmentUnits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasurmentUnitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeasurmentUnits::class);
    }

    // /**
    //  * @return MeasurmentUnits[] Returns an array of MeasurmentUnits objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeasurmentUnits
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
