<?php

namespace App\Repository;

use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Recipes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipes[]    findAll()
 * @method Recipes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipes::class);
    }

    // /**
    //  * @return Recipes[] Returns an array of Recipes objects
    //  */
    public function findOrderedByDate($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.category = :val')
            ->setParameter('val', $value)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Recipes[] Returns an array of Recipes objects
    //  */
    public function findAllOrderedByDate()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Recipes[] Returns an array of Recipes objects
    //  */
    public function findByCategoryAndIngredients($category, object $ingredients)
    {
        $result = [];

        if($ingredients->isEmpty()) {
            return $this->createQueryBuilder('r')
                ->andWhere('r.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getResult()
                ;
        } else {
            foreach ($ingredients as $ingredient) {
                $recipes = $this->createQueryBuilder('r')
                    ->leftJoin('r.recipyIngradients', 'i')
                    ->andWhere('i.ingradient = :ingredient')
                    ->andWhere('r.category = :category')
                    ->setParameter('category', $category)
                    ->setParameter('ingredient', $ingredient)
                    ->orderBy('r.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
                ;
                foreach ($recipes as $recipe) {
                    if (!in_array($recipe, $result)) {
                        array_push($result, $recipe);
                    }
                }
            }
            return $result;
        }
    }



    /*
    public function findOneBySomeField($value): ?Recipes
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
