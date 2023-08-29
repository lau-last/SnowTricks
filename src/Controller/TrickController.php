<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{

    #[Route('/trick-creation', name: 'app_trick_creation')]
    public function trickCreation(): Response
    {
        return $this->render('trick_creation/index.html.twig', [
            'controller_name' => 'TrickController',
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
