<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickDisplayController extends AbstractController
{
    #[Route('/trick/display', name: 'app_trick_display')]
    public function index(): Response
    {
        return $this->render('trick_display/index.html.twig', [
            'controller_name' => 'TrickDisplayController',
        ]);
    }
}
