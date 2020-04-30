<?php


namespace App\Controller\Admin;


use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CommentController
 * @package App\Controller\Admin
 *
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="admin_comment_delete")
     */
    public function delete(CommentRepository $repository, EntityManagerInterface $manager, $id)
    {
        $comment = $repository->findOneBy(['id' => $id]);
        $recipe = $comment->getRecipe()->getId();
        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('single_recipe', ['id' => $recipe]);
    }
}