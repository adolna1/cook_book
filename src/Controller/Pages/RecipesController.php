<?php


namespace App\Controller\Pages;

use App\Entity\Recipes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecipesController
 * @package App\Controller\Pages
 *
 * @Route("recipe")
 */
class RecipesController extends AbstractController
{
    /**
     * @Route("/{id}", name="single_recipe")
     */
    public function recipe(Recipes $recipe)
    {
        return $this->render('pages/recipe.html.twig', ['recipe' => $recipe]);
    }

}