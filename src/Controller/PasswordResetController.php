<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordResetController extends AbstractController
{
    #[Route('/password/reset', name: 'app_password_reset')]
    public function index(): Response
    {
        return $this->render('password_reset/index.html.twig', [
            'controller_name' => 'PasswordResetController',
        ]);
    }
}
