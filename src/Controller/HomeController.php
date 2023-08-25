<?php

namespace App\Controller;


use App\Repository\TrickRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findBy([], null, 4);
        $totalTricks = $trickRepository->count([]);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'totalTricks' => $totalTricks,
        ]);
    }


    #[Route('/load_trick', name: 'app_load')]
    public function loadMore(TrickRepository $trickRepository, Request $request): Response
    {
        $json = json_decode($request->getContent(), true);
        $offset = $json['offset'];
        $limit = $json['limit'];
        $tricks = $trickRepository->findBy([], null, $limit, $offset);
        return new JsonResponse($this->renderView('home/_trick-cards.html.twig', [
            'tricks' => $tricks,
        ]), json: true);
    }


}
