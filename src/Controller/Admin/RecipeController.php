<?php


namespace App\Controller\Admin;

use App\Entity\Recipes;
use App\Entity\RecipyIngradients;
use App\Form\IngradientFormType;
use App\Form\RecipeEditFormType;
use App\Form\RecipeFormType;
use App\Repository\RecipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class RecipeController
 * @package App\Controller\Admin
 *
 * @Route("/admin/recipes")
 */
class RecipeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * @Route("", name="admin_recipes_index")
     */
    public function index()
    {
        $recipes = $this->manager->getRepository(Recipes::class)->findAll();
        return $this->render('admin/recipe/index.html.twig', ['recipes' => $recipes]);
    }

    /**
     * @Route("/new", name="admin_recipes_new")
     * @param Request $request
     */
    public function new(Request $request)
    {
        $recipeIngradient = new RecipyIngradients();
        $recipe = new Recipes();
        $recipe->setCreatedAt(new \DateTime());
        $recipe->addRecipyIngradient($recipeIngradient);
        //$form = $this->createForm(IngradientFormType::class, $recipeIngradient);
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($recipe);
            $this->manager->flush();
        }

/*        if($form->isSubmitted() && $form->isValid()) {
            $ingredients = $form->get('ingradient')->getData();
            foreach ($ingredients as $ingredient) {
                $recipeIngradient->setIngradient($ingredient);
                $this->manager->persist($recipeIngradient);
            }
            $this->manager->flush();
        }*/

        return $this->render('admin/recipe/ingredient_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="admin_recipes_edit")
     */
    public function edit(Recipes $recipe, Request $request)
    {
        $form = $this->createForm(RecipeEditFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($recipe);
            $this->manager->flush();
        }

        return $this->render('admin/recipe/ingredient_form.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="admin_recepes_delete")
     * @param Recipes $recipes
     * @return RedirectResponse
     */
    public function delete(RecipesRepository $repository, $id)
    {
        $recipe = $repository->findOneBy(['id' => $id]);
        $this->manager->remove($recipe);
        $this->manager->flush();

        return $this->redirectToRoute('admin_recipes_index');
    }

}