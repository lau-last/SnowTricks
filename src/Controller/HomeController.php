<?php

namespace App\Controller;


use App\Entity\Trick;
use App\Entity\TrickPicture;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(TrickRepository $trickRepository, EntityManagerInterface $manager): Response
    {

        $tricks = $trickRepository->findBy([], ["createdAt" => "DESC"], 4);
        $totalTricks = $trickRepository->count([]);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'totalTricks' => $totalTricks,
        ]);
    }


    #[Route('/load-trick', name: 'app_load_trick')]
    public function loadMoreTrick(TrickRepository $trickRepository, Request $request): Response
    {
        $json = json_decode($request->getContent(), true);
        $offset = $json['offset'];
        $limit = $json['limit'];
        $tricks = $trickRepository->findBy([], null, $limit, $offset);
        return new JsonResponse($this->renderView('home/_trick_cards.html.twig', [
            'tricks' => $tricks,
        ]), json: true);
    }


}
