<?php

namespace App\Repository;

use App\Entity\UserConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserConfig[]    findAll()
 * @method UserConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserConfig::class);
    }

    // /**
    //  * @return UserConfig[] Returns an array of UserConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserConfig
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
