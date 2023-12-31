<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\TrickPicture;
use App\Entity\TrickVideo;
use App\Form\CommentType;
use App\Form\TrickModificationType;
use App\Form\TrickPictureModificationType;
use App\Form\TrickType;
use App\Form\TrickVideoModificationType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\TrickEdit;
use App\Service\UploadPicture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{

    #[Route('/trick-creation', name: 'app_trick_creation')]
    public function trickCreation(
        Request   $request,
        TrickEdit $trickEdit
    ): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('pictures')->count() < 1 && $form->get('videos')->count() < 1) {
                $this->addFlash('error', 'You must have at least one photo or video to present the trick');
                return $this->redirectToRoute('app_trick_creation');
            }

            $trickEdit->edit($trick);

            $this->addFlash('success', 'Trick added successfully');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('trick_creation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/trick-display/{slug}', name: 'app_trick_display')]
    public function trickDisplay(
        TrickRepository        $trickRepository,
        CommentRepository      $commentRepository,
        string                 $slug,
        Request                $request,
        EntityManagerInterface $manager
    ): Response
    {
        $comment = new Comment();

        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $comments = $commentRepository->findBy(['trick' => $trick], ["createdAt" => "DESC"], 5);
        $totalComment = count($trick->getComments());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment
                ->setTrick($trick)
                ->setUser($this->getUser())
                ->setContent($comment->getContent());

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_trick_display', ['slug' => $slug]);
        }


        return $this->render('trick_display/index.html.twig', [
            'trick' => $trick,
            'totalComment' => $totalComment,
            'comments' => $comments,
            'form' => $form->createView(),
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


    #[Route('/trick-modification/{slug}', name: 'app_trick_modification')]
    public function trickModification(
        TrickRepository $trickRepository,
        string          $slug,
        Request         $request,
        TrickEdit       $trickEdit
    ): Response
    {

        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickEdit->edit($trick, true);
            $this->addFlash('success', 'Trick successfully modified');
            return $this->redirectToRoute('app_trick_modification', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick_modification/index.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/trick-delete/{slug}', name: 'app_trick_delete')]
    public function trickDelete(
        TrickRepository        $trickRepository,
        string                 $slug,
        EntityManagerInterface $manager
    ): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $manager->remove($trick);
        $manager->flush();
        $this->addFlash('success', 'Trick successfully removed');
        return $this->redirectToRoute('app_home');
    }


    #[Route('/trick-delete-picture/{slug}/{id}', name: 'app_trick_delete_picture')]
    public function trickPictureDelete(
        TrickRepository        $trickRepository,
        string                 $slug,
        int                    $id,
        EntityManagerInterface $manager,
        UploadPicture          $uploadPicture
    ): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $picture = $manager->getRepository(TrickPicture::class);
        $pictureId = $picture->find($id);

        $uploadPicture->delete($pictureId);

        $trick->setUpdatedAt(new \DateTime());
        $first = $pictureId->isFirstPicture();

        $manager->remove($pictureId);
        $manager->flush();

        $countPicture = $trick->getPictures()->count();

        if ($first && $countPicture > 0) {
            $trick->getPictures()->first()->setFirstPicture(true);
            $manager->flush();
        }

        $this->addFlash('success', 'Photo deleted successfully');

        return $this->redirectToRoute('app_trick_modification', ['slug' => $slug]);
    }


    #[Route('/trick-delete-video/{slug}/{id}', name: 'app_trick_delete_video')]
    public function trickVideoDelete(
        TrickRepository        $trickRepository,
        string                 $slug,
        int                    $id,
        EntityManagerInterface $manager
    ): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $video = $manager->getRepository(TrickVideo::class);
        $videoId = $video->find($id);
        $trick->setUpdatedAt(new \DateTime());

        $manager->remove($videoId);
        $manager->flush();

        $this->addFlash('success', 'Video deleted successfully');

        return $this->redirectToRoute('app_trick_modification', ['slug' => $slug]);

    }


    #[Route('/trick-picture-first/{slug}/{id}', name: 'app_trick_picture_first')]
    public function trickPictureFirst(
        TrickRepository        $trickRepository,
        string                 $slug,
        int                    $id,
        EntityManagerInterface $manager
    ): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        $pictures = $trick->getPictures();
        foreach ($pictures as $picture) {
            $picture->setFirstPicture(false);
        }
        $picture = $manager->getRepository(TrickPicture::class);
        $pictureId = $picture->find($id);
        $pictureId->setFirstPicture(true);
        $trick->setUpdatedAt(new \DateTime());

        $manager->persist($trick);
        $manager->flush();

        $this->addFlash('success', 'Photo brought to foreground successfully');

        return $this->redirectToRoute('app_trick_modification', ['slug' => $slug]);
    }


}
