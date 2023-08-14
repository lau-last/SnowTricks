<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickModificationController extends AbstractController
{
    #[Route('/trick/modification', name: 'app_trick_modification')]
    public function index(): Response
    {
        return $this->render('trick_modification/index.html.twig', [
            'controller_name' => 'TrickModificationController',
        ]);
    }
}
