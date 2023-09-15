<?php

namespace App\Controller;


use App\Entity\TrickPicture;
use App\Repository\TrickPictureRepository;
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
    public function index(TrickRepository $trickRepository, TrickPictureRepository $pictureRepository): Response
    {
//        $tricksFixture = $trickRepository->findAll();
//        foreach ($tricksFixture as $trick){
//            $trickPicCollection = $trick->getPictures();
//
//            $setDefaultFirst = true;
//
//            foreach ($trick->getPictures() as $picture) {
//                if($picture->isFirstPicture()){
//                    $setDefaultFirst = false;
//                }
//                if ($picture->getFile() === null){
//                    continue;
//                }
//                $picture->setFileName($this->uploadPicture->upload($picture));
//                $picture->setAlt($picture->getAlt());
//                $this->manager->persist($picture);
//            }
//
//            if($setDefaultFirst) {
//                $trick->getPictures()->get(0)->setFirstPicture(true);
//            }
//
//        }

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
