<?php

namespace App\Controller;


use App\Repository\TrickRepository;
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
        $tricks = $trickRepository->findBy([], null, 5);
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }


    #[Route('/load-more/', name: 'app_home_load_more', methods: ['POST'])]
    public function loadMore(Request $request, TrickRepository $trickRepository): Response
    {
        $arrRequest = json_decode($request->getContent(), true);

        if(!isset($arrRequest["offset"]) || !is_numeric($arrRequest["offset"])) {
            return new Response(status: 400);
        }

        $offset = $arrRequest["offset"];
        $nextTricks = $trickRepository->findBy(criteria: [], limit: 5, offset: $offset);
        $tricksHtml = $this->renderView("home/load_more.html.twig", [
            "tricks" => $nextTricks,
        ]);

        return new JsonResponse($tricksHtml);
    }


}
