<?php

namespace App\Controller;


use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\services\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();
        return $this->render('home/index.html.twig',[
            'tricks' => $tricks,
        ]);
    }
}
