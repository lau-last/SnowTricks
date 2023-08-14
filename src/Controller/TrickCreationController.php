<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickCreationController extends AbstractController
{
    #[Route('/trick/creation', name: 'app_trick_creation')]
    public function index(): Response
    {
        return $this->render('trick_creation/index.html.twig', [
            'controller_name' => 'TrickCreationController',
        ]);
    }
}
