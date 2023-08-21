<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{

    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hash, SluggerInterface $slugger): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('media')->getData();
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFileName);
            $newFilename = $safeFilename.'-'.md5(uniqid(rand(), true)).'.'.$file->guessExtension();
            $file->move($this->getParameter('profiles_pictures_directory'), $newFilename);

            $hash = $hash->hashPassword($user, $user->getPassword());

            $user
                ->setMedia($newFilename)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setToken('eeee')
                ->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
