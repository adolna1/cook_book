<?php


namespace App\Controller\Pages;


use App\Entity\Recipes;
use App\Entity\RecipyIngradients;
use App\Form\RecipeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AddController
 * @package App\Controller\Pages
 * 
 * @Route("/add-recipe")
 */
class AddController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * 
     * @Route("", name="add_recipe")
     */
    public function index(Request $request)
    {
        $recipeIngradient = new RecipyIngradients();
        $recipe = new Recipes();
        $recipe->setCreatedAt(new \DateTime());
        $recipe->addRecipyIngradient($recipeIngradient);
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('recipes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $recipe->setImageFileName($newFilename);
            }
            $this->manager->persist($recipe);
            $this->manager->flush();

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render('pages/new.html.twig', ['form' => $form->createView()]);

    }
}