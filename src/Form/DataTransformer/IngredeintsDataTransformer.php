<?php


namespace App\Form\DataTransformer;


use App\Entity\Ingradients;
use App\Repository\IngradientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class IngredeintsDataTransformer implements DataTransformerInterface
{
    /**
     * @var IngradientsRepository
     */
    private IngradientsRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(IngradientsRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->manager = $entityManager;
    }

    public function transform($ingredients)
    {
        if (null == $ingredients) {
            return '';
        }

        $ingredientNames = [];

        foreach ($ingredients as $ingredient) {
            $ingredientNames[] = $ingredient->getTitle();

            return implode(',', $ingredientNames);
        }
    }

    public function reverseTransform($value)
    {
        $ingredientNames = explode(',', $value);

        foreach ($ingredientNames as $ingredientName) {
            if('' !== trim($ingredientName)) {
                $ingredientName = trim($ingredientName);
                $ingredient = $this->repository->findOneBy(['name' => $ingredientName]);
                if(null == $ingredient) {
                    $ingredient = new Ingradients();
                    $ingredient->setName($ingredientName);
                    $this->manager->persist($ingredient);
                    $this->manager->flush();
                }
                $ingredients = $ingredient;
            }
        }
        return $ingredients;
    }
}