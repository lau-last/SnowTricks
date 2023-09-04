<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\UploadPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{

    #[Route('/trick-creation', name: 'app_trick_creation')]
    public function trickCreation(
        Request                $request,
        UploadPicture          $uploadPicture,
        EntityManagerInterface $manager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick
                ->setName($trick->getName())
                ->setDescription($trick->getDescription())
                ->setCategory($trick->getCategory())
                ->setCreatedAt(new \DateTimeImmutable());

            foreach ($trick->getPictures() as $picture) {
                $uploadPicture->upload($picture);
                $trick->addPicture($picture);
            }

            $manager->persist($trick);
            $manager->flush();
        }

        return $this->render('trick_creation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/trick-display/{slug}', name: 'app_trick_display')]
    public function trickDisplay(TrickRepository $trickRepository, string $slug): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);

        return $this->render('trick_display/index.html.twig', [
            'trick' => $trick,
        ]);
    }


}
