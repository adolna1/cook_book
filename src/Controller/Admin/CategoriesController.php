<?php


namespace App\Controller\Admin;


use App\Entity\Categories;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoriesController
 * @package App\Controller\Admin
 *
 * @Route("/admin/categories")
 */
class CategoriesController extends AbstractController
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
     * @Route("", name="admin_categories_index")
     */
    public function index(CategoriesRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render('admin/categories/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/new", name="admin_categories_new")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();
        }

        return $this->render('admin/categories/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="admin_categories_edit")
     * @param Categories $categorie
     */
    public function edit(Categories $category, Request $request)
    {
        $form = $this->createForm(CategoriesFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();
        }

        return $this->render('admin/categories/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Categories $category
     *
     * @Route("/delete/{id}", name="admin_categories_delete")
     */
    public function delete(CategoriesRepository $repository, $id)
    {
        $category = $repository->findOneBy(['id' => $id]);
        $this->manager->remove($category);
        $this->manager->flush();

        return $this->redirectToRoute('admin_categories_index');
    }

}