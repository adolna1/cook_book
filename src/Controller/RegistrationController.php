<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserConfig;
use App\Form\RegistrationFormType;
use App\Form\RemindPasswordFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * Class RegistrationController.
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("rejestracja", name="register")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $user->setIsActive(false);

            $emailHash = bin2hex(random_bytes(16));
            $user->setEmailHash($emailHash);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('emailform@example.com')
                ->to($user->getEmail())
                ->subject('Aktywacja konta')
                ->htmlTemplate('email/registraionEmail.html.twig')
                ->context(['emailHash' => $emailHash]);

            $mailer->send($email);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("aktywuj-konto/{hash}", name="activate")
     * @param string $hash
     * @param EntityManagerInterface $entityManager
     * @param LoginFormAuthenticator $authenticator
     * @param GuardAuthenticatorHandler $guardHandler
     * @param Request $request
     * @return Response
     */
    public function activateUser(string $hash,
                                 EntityManagerInterface $entityManager,
                                 LoginFormAuthenticator $authenticator,
                                 GuardAuthenticatorHandler $guardHandler,
                                 Request $request): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['emailHash' => $hash]);
        if ($user) {
            $user->setIsActive(true);
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

    /**
     * @Route("przypomnij-haslo", name="remindPassword")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function remainPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $form = $this->createForm(RemindPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($user && true === $user->getIsActive()) {
                $emailHash = bin2hex(random_bytes(16));
                $user->setEmailHash($emailHash);
                $entityManager->persist($user);
                $entityManager->flush();

                $email = (new TemplatedEmail())
                    ->from('emailfrom@example.pl')
                    ->to($user->getEmail())
                    ->subject('Zmiana hasła')
                    ->htmlTemplate('email/changePassword.html.twig')
                    ->context(['emailHash' => $emailHash, 'myemail' => $email]);

                $mailer->send($email);
            }
        }

        return $this->render('registration/remindPassword.html.twig', ['form' => $form->createView()]);
    }
}
