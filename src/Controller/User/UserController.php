<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\UserConfig;
use App\Form\ChangePasswordFormType;
use App\Form\UserConfigFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserController.
 *
 * @Route("/profil")
 */
class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("", name="user_index")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $currentUser = $this->getUser();
        $formPassword = $this->createForm(ChangePasswordFormType::class, $currentUser);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $currentUser->setPassword(
                $passwordEncoder->encodePassword(
                    $currentUser,
                    $formPassword->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }

        return $this->render('user/index.html.twig', [
            'changePasswordForm' => $formPassword->createView(),
        ]);
    }

    /**
     * @Route("/zmien-haslo/{hash}", name="changePassword")
     *
     * @param string $hash
     * @param Request $request
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function changePassword(string $hash,
                                   Request $request,
                                   GuardAuthenticatorHandler $guardHandler,
                                   LoginFormAuthenticator $authenticator,
                                   EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['emailHash' => $hash]);
        if ($user) {
            $user->setEmailHash(null);
            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        } else {
            return $this->render('pages/index.html.twig');
        }
    }
}
