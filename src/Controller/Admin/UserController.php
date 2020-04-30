<?php


namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller\Admin
 *
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return Response
     *
     * @Route("", name="admin_users_index")
     */
    public function index()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('admin/user/index.html.twig', ['users'=> $users]);
    }

    /**
     * @Route("/nowy", name="admin_users_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setIsActive(true);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

        }
        return $this->render('admin/user/form_new.html.twig', ['newUserForm' => $form->createView()]);
    }

    /**
     * @Route("/edytuj/{id}", name="admin_users_edit")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function edit(User $user, Request $request) {

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('plainPassword')->getData() !==null) {
                $user->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        return $this->render('admin/user/form_edit.html.twig', ['editUserForm' => $form->createView()]);
    }

    /**
     * @Route("/block/{id}", name="admin_users_block")
     */
    public function block(User $user)
    {
        $user->setIsActive(0);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_users_index');
    }

    /**
     * @Route("/activate/{id}", name="admin_users_activate")
     */
    public function activate(User $user)
    {
        $user->setIsActive(1);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_users_index');
    }

}