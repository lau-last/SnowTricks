<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\JWT;
use App\Service\SendMail;
use App\Service\UploadPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\SluggerInterface;

class SecurityController extends AbstractController
{


    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/registration', name: 'app_registration')]
    public function registration(
        Request                     $request,
        EntityManagerInterface      $manager,
        UserPasswordHasherInterface $hash,
        SluggerInterface            $slugger,
        MailerInterface             $mailer,
        JWT                         $tokenService,
        UploadPicture               $uploadPicture): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadPicture->upload($form, 'media', $slugger, $this->getParameter('profiles_pictures_directory'));
            $hash = $hash->hashPassword($user, $user->getPassword());
            $token = $tokenService->generate(['user_email' => $user->getEmail()], $this->getParameter('jwtoken_secret'));

            $user
                ->setMedia($uploadPicture->getNewFilename())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword($hash)
                ->setToken($token)
                ->setIsRegistered(false);

            $manager->persist($user);
            $manager->flush();

            (new SendMail())->send($mailer, $user->getEmail(), 'email/registration.html.twig', ['user' => $user, 'token' => $token]);

            $this->addFlash('success', 'Un email de verification vous a été envoyé sur l\'adress : ' . $user->getEmail() . '.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/verify-registration-token/{token}', name: 'app_verify_registration_token')]
    public function verifyRegistration(
        string                 $token,
        JWT                    $tokenService,
        EntityManagerInterface $manager,
        UserRepository         $userRepository): Response
    {
        if (!$tokenService->isValid($token) || !$tokenService->check($token, $this->getParameter('jwtoken_secret'))) {
            $this->addFlash('error', 'Le token n\'est pas un token valide.');
            return $this->redirectToRoute('app_home');
        }

        if ($tokenService->isExpired($token)) {
            $this->addFlash('error', 'Le token a expiré.');
            return $this->redirectToRoute('app_home');
        }

        $payload = $tokenService->getPayload($token);
        $user = $userRepository->findOneBy(['email' => $payload['user_email']]);

        if (!$user || $user->isIsRegistered()) {
            $this->addFlash('error', 'L\'utilisateur est déjà vérifié ou est invalide');
            return $this->redirectToRoute('app_home');
        }

        $user->setIsRegistered(true);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'Votre adresse email a bien été validée !');

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
    public function logout(): Response
    {
    }


    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/forget-password', name: 'app_forget_password')]
    public function forgetPassword(
        Request                $request,
        JWT                    $tokenService,
        UserRepository         $userRepository,
        MailerInterface        $mailer,
        EntityManagerInterface $manager): Response
    {
        $user = new User();
        $form = $this->createForm(ForgetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userRepository->findOneBy(['name' => $user->getName()]);
            $token = $tokenService->generate(['user_email' => $user->getEmail()], $this->getParameter('jwtoken_secret'));

            $user->setToken($token);

            $manager->persist($user);
            $manager->flush();

            (new SendMail())->send($mailer, $user->getEmail(), 'email/forgot_password.html.twig', ['user' => $user, 'token' => $token]);

            $this->addFlash('success', 'Un email pour réinitialiser votre mot de passe vous a été envoyé à votre adresse mail.');

            return $this->redirectToRoute('app_home');
        }
        return $this->render('forgot_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(
        JWT                         $tokenService,
        string                      $token,
        UserRepository              $userRepository,
        Request                     $request,
        EntityManagerInterface      $manager,
        UserPasswordHasherInterface $hash): Response
    {
        if (!$tokenService->isValid($token) || !$tokenService->check($token, $this->getParameter('jwtoken_secret'))) {
            $this->addFlash('error', 'Vous n\'avez pas un token valide.');
            return $this->redirectToRoute('app_home');
        }

        if ($tokenService->isExpired($token)) {
            $this->addFlash('error', 'Le token est expiré.');
            return $this->redirectToRoute('app_home');
        }

        $payload = $tokenService->getPayload($token);
        $user = $userRepository->findOneBy(['email' => $payload['user_email']]);
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('password_reset/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
