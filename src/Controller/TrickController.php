<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\UploadPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{

    #[Route('/trick-creation', name: 'app_trick_creation')]
    public function trickCreation(
        Request                $request,
        UploadPicture          $uploadPicture,
        EntityManagerInterface $manager,
        SluggerInterface       $slugger): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick
                ->setName($trick->getName())
                ->setSlug($slugger->slug($trick->getName()))
                ->setDescription($trick->getDescription())
                ->setCategory($trick->getCategory());

            foreach ($trick->getPictures() as $picture) {
                $picture->setFileName($uploadPicture->upload($picture));
                $picture->setAlt($picture->getAlt());
            }
            foreach ($trick->getVideos() as $video) {
                $video->setUrl($video->getUrlEmbed());
            }

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash('success', 'Trick ajouté avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick_creation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/trick-display/{slug}', name: 'app_trick_display')]
    public function trickDisplay(TrickRepository $trickRepository, CommentRepository $commentRepository, string $slug): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $comments = $commentRepository->findBy(['trick' => $trick], ["createdAt" => "DESC"], 4);
        $totalComment = count($trick->getComments());

        return $this->render('trick_display/index.html.twig', [
            'trick' => $trick,
            'totalComment' => $totalComment,
            'comments' => $comments,
        ]);
    }


    #[Route('/load-comment', name: 'app_load_comment')]
    public function loadMoreComment(CommentRepository $commentRepository, Request $request): Response
    {
        $json = json_decode($request->getContent(), true);
        $offset = $json['offset'];
        $limit = $json['limit'];
        $trickId = $json['trickId'];
        $comments = $commentRepository->findBy(['trick' => $trickId], null, $limit, $offset);
        return new JsonResponse($this->renderView('trick_display/_comment_card.html.twig', [
            'comments' => $comments,
        ]), json: true);
    }


}
