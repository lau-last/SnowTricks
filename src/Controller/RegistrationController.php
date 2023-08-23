<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\JWT;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
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
        JWT                         $tokenService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('media')->getData();
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFileName);
            $newFilename = $safeFilename . '-' . md5(uniqid(rand(), true)) . '.' . $file->guessExtension();
            $file->move($this->getParameter('profiles_pictures_directory'), $newFilename);

            $hash = $hash->hashPassword($user, $user->getPassword());

            $token = $tokenService->generate(['user_email' => $user->getEmail()], $this->getParameter('jwtoken_secret'));

            $user
                ->setMedia($newFilename)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setPassword($hash)
                ->setToken($token)
                ->setIsRegistered(false);

            $manager->persist($user);
            $manager->flush();

            $email = (new TemplatedEmail())
                ->from('no-reply@snowtricks.oc')
                ->to($user->getEmail())
                ->subject('Veuillez confirmer votre adresse email')
                ->htmlTemplate('email/registration.html.twig')
                ->context(['user' => $user, 'token' => $token]);

            $mailer->send($email);

            $this->addFlash('success', 'Un email de verification vous a été envoyé sur l\'adress : ' . $user->getEmail() . '.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/verify_registration_token/{token}', name: 'app_verify_registration_token')]
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


}
