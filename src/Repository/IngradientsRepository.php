<?php

namespace App\Repository;

use App\Entity\Ingradients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Ingradients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingradients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingradients[]    findAll()
 * @method Ingradients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngradientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingradients::class);
    }

    // /**
    //  * @return Ingradients[] Returns an array of Ingradients objects
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
    public function findOneBySomeField($value): ?Ingradients
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
