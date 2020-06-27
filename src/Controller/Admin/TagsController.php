<?php


namespace App\Controller\Admin;


use App\Entity\Tags;
use App\Form\TagsFormType;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagsController
 * @package App\Controller\Admin
 *
 * @Route("/tags")
 */
class TagsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var TagsRepository
     */
    private TagsRepository $repository;

    public function __construct(EntityManagerInterface $manager, TagsRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("", name="admin_tags_index")
     * @return Response
     */
    public function index()
    {
        $tags = $this->repository->findAll();

        return $this->render('admin/tags/index.html.twig', ['tags' => $tags]);
    }

    /**
     * @Route("/new", name="admin_tags_new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request)
    {
        $tag = new Tags();
        $form = $this->createForm(TagsFormType::class, $tag);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $tag->setCreatedAt(new \DateTime());
            $tag->setSlug($form->get('title')->getData());
            $this->manager->persist($tag);
            $this->manager->flush();

            return $this->redirectToRoute('admin_tags_index');
        }
        return $this->render('admin/tags/form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/edit/{id}", name="admin_tags_edit")
     * @param Tags $tag
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function edit(Tags $tag, Request $request)
    {
        $form = $this->createForm(TagsFormType::class, $tag);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $tag->setCreatedAt(new \DateTime());
            $tag->setSlug($form->get('title')->getData());
            $this->manager->persist($tag);
            $this->manager->flush();

            return $this->redirectToRoute('admin_tags_index');
        }
        return $this->render('admin/tags/form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/delete/{id}", name="admin_tags_delete")
     * @return RedirectResponse
     */
    public function delete(Tags $tag)
    {
        $this->manager->remove($tag);
        $this->manager->flush();

        return $this->redirectToRoute('admin_tags_index');
    }
}