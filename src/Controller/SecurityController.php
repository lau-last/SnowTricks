<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\SendMail;
use App\Service\UploadPicture;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    #[Route('/registration', name: 'app_registration')]
    public function registration(
        Request                     $request,
        EntityManagerInterface      $manager,
        UserPasswordHasherInterface $hash,
        MailerInterface             $mailer,
        UploadPicture               $uploadPicture
    ): Response {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $hash->hashPassword($user, $user->getPassword());
            $hashToken = bin2hex(random_bytes(32));

            $user
                ->setMedia($uploadPicture->uploadProfile($form, 'media', $this->getParameter('profiles_pictures_directory')))
                ->setPassword($hash)
                ->setHashToken($hashToken)
                ->setExpirationDate(strtotime('2 hours'));

            $manager->persist($user);
            $manager->flush();

            (new SendMail())->send($mailer, $user->getEmail(), 'email/registration.html.twig', ['user' => $user, 'hashToken' => $hashToken]);

            $this->addFlash('success', 'A verification email has been sent to you to the address: ' . $user->getEmail() . '.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/verify-registration-hashToken/{hashToken}', name: 'app_verify_registration_hashToken')]
    public function verifyRegistration(
        string                 $hashToken,
        EntityManagerInterface $manager,
        UserRepository         $userRepository
    ): Response {

        $user = $userRepository->findOneBy(['hashToken' => $hashToken]);

        if (empty($user)) {
            $this->addFlash('error', 'Unknown token');
            return $this->redirectToRoute('app_home');
        }
        if ($user->isActive() === true) {
            $this->addFlash('error', 'Your account is already valid');
            return $this->redirectToRoute('app_home');
        }
        if ($user->getExpirationDate() > strtotime('now')) {
            $user->setActive(true);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Your account has been successfully validated');
            return $this->redirectToRoute('app_home');
        }
        if ($user->getExpirationDate() < strtotime('now')) {
            $this->addFlash('error', 'The link has expired');
            return $this->redirectToRoute('app_home');
        }

        $this->addFlash('success', 'Your email address has been validated!');

        return $this->redirectToRoute('app_home');
    }


    #[Route('/connection', name: 'app_connection')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('connection/index.html.twig', [
            'error' => $error,
        ]);
    }


    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }


    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    #[Route('/forget-password', name: 'app_forget_password')]
    public function forgetPassword(
        Request                $request,
        UserRepository         $userRepository,
        MailerInterface        $mailer,
        EntityManagerInterface $manager
    ): Response {
        $user = new User();
        $form = $this->createForm(ForgetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $user = $userRepository->findOneBy(['username' => $user->getUsername()]);
            $hashToken = bin2hex(random_bytes(32));

            $user->setHashToken($hashToken);

            $manager->persist($user);
            $manager->flush();

            (new SendMail())->send($mailer, $user->getEmail(), 'email/forgot_password.html.twig', ['user' => $user, 'hashToken' => $hashToken]);

            $this->addFlash('success', 'An email to reset your password has been sent to your email address.');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('forgot_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/reset-password/{hashToken}', name: 'app_reset_password')]
    public function resetPassword(
        string                      $hashToken,
        UserRepository              $userRepository,
        Request                     $request,
        EntityManagerInterface      $manager,
        UserPasswordHasherInterface $hash
    ): Response {
        $user = $userRepository->findOneBy(['hashToken' => $hashToken]);

        if (empty($user)) {
            $this->addFlash('error', 'Unknown token');
            return $this->redirectToRoute('app_home');
        }

        if ($user->getExpirationDate() < strtotime('now')) {
            $this->addFlash('error', 'The link has expired');
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your password has been changed.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('password_reset/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
