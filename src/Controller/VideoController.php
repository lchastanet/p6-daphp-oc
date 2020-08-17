<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/video")
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/admin/ajouter", name="video_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('video_index');
        }

        return $this->render('video/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/admin/modifier", name="video_edit", methods={"POST"})
     */
    public function edit(Request $request, Video $video, EntityManagerInterface $entityManager): Response
    {
        $videoURL = $request->request->get('videoURL');

        if (filter_var($videoURL, FILTER_VALIDATE_URL)) {
            $video->setURL($videoURL);

            if ($this->isCsrfTokenValid('editVideo', $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->json("Item updated", 200);
            }

            return $this->json("Token incorrecte", 403);
        }

        return $this->json("URL de la video incorrecte", 403);
    }

    /**
     * @Route("/{id}/admin", name="video_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete' . $video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();

            return $this->json("Item deleted", 200);
        }

        return $this->json("Something, somewhere, went terribly wrong", 500);
    }
}
