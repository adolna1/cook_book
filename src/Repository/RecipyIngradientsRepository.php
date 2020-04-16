<?php

namespace App\Repository;

use App\Entity\RecipyIngradients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RecipyIngradients|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipyIngradients|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipyIngradients[]    findAll()
 * @method RecipyIngradients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipyIngradientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipyIngradients::class);
    }

    // /**
    //  * @return RecipyIngradients[] Returns an array of RecipyIngradients objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipyIngradients
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
