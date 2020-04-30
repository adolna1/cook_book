<?php


namespace App\Controller\Pages;

use App\Entity\Categories;
use App\Entity\Comment;
use App\Entity\Recipes;
use App\Form\CommentFormType;
use App\Form\FindRecipeFormType;
use App\Repository\CategoriesRepository;
use App\Repository\CommentRepository;
use App\Repository\RecipesRepository;
use App\Repository\RecipyIngradientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecipesController
 * @package App\Controller\Pages
 *
 * @Route("recipes")
 */
class RecipesController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;

    public function __construct(PaginatorInterface $paginator, EntityManagerInterface $manager, CommentRepository $repository)
    {
        $this->paginator = $paginator;
        $this->manager = $manager;
        $this->commentRepository = $repository;
    }

    /**
     * @Route("/{id}", name="single_recipe")
     */
    public function recipe(Recipes $recipe, Request $request)
    {
        $user = $this->getUser();
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        $comments = $this->commentRepository->findBy(['recipe' => $recipe]);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($user);
            $comment->setRecipe($recipe);
            $this->manager->persist($comment);
            $this->manager->flush();
            $comments = $this->commentRepository->findBy(['recipe' => $recipe]);
        }

        return $this->render('pages/recipe.html.twig', ['recipe' => $recipe, 'comments' => $comments, 'form' =>$form->createView()]);
    }

    /**
     * @param Request $request
     *
     * @Route("", name="recipe_index")
     */
    public function index(Request $request, RecipesRepository $repository, RecipyIngradientsRepository $recipyIngradientsRepository)
    {
        $recipes = $repository->findAllOrderedByDate();
        $recipes = $this->paginator->paginate($recipes, $request->query->getInt('page', 1),4);
        $form = $this->createForm(FindRecipeFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $category = $form->get('category')->getData();
            if($category){
                $recipes = $repository->findOrderedByDate($category);
                $recipes = $this->paginator->paginate($recipes, $request->query->getInt('page', 1),4);
            } else {
                $recipes = $repository->findAllOrderedByDate();
                $recipes = $this->paginator->paginate($recipes, $request->query->getInt('page', 1),4);
            }

            $ingredients = $form->get('ingredients')->getData();

            $recipes = [];

            foreach ($ingredients as $ingredient) {
                $recipeIngredients = $recipyIngradientsRepository->findBy(['ingradient' => $ingredient]);
                foreach ($recipeIngredients as $recipeIngredient) {
                    $recipes[] = $recipeIngredient->getRecipe()->getTitle();
                }
            }
            $recipes = array_unique( array_diff_assoc( $recipes, array_unique( $recipes ) ) );

            $recipes2 = [];
            foreach ($recipes as $recipe) {
                $recipes2[] = $repository->findOneBy(['title' => $recipe]);
            }
            dd($recipes2);
        }

        return $this->render('pages/recipes/index.html.twig', ['form' => $form->createView(), 'recipes' => $recipes]);
    }

}