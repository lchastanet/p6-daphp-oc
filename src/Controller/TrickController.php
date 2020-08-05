<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Form\CommentType;
use App\Form\NewTrickType;
use App\Form\EditTrickType;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class TrickController extends AbstractController
{
    /**
     * @Route("/", name="trick_index", methods={"GET"})
     */
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->getSome(8, 0),
        ]);
    }

    /**
     * @Route("/charger-tricks/{index}", name="trick_load", methods={"GET"})
     */
    public function loadTricks($index, TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->getSome(8, $index);

        $datas = [];

        foreach ($tricks as $trick) {
            $data["id"] = $trick->getId();
            $data["title"] = $trick->getTitle();
            $data["pictureOne"] = $trick->getPictures()->last()->getURL();

            array_push($datas, $data);
        }

        return $this->json($datas, 200);
    }

    /**
     * @Route("/admin/trick/nouveau", name="trick_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader, Security $security): Response
    {
        $trick = new Trick();
        $form = $this->createForm(NewTrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUser($security->getUser());
            $trick->setCreatedAt(new \DateTime());

            $pictureFiles = $trick->getPictureFiles();

            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

            foreach ($pictureFiles as $pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);

                $picture = new Picture();
                $picture->setURL($pictureFileName);
                $trick->addPicture($picture);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trick);
            $entityManager->flush();

            return $this->redirectToRoute('trick_index');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{id}", name="trick_show", methods={"GET"})
     */
    public function show(Trick $trick): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_new', ['idTrick' => $trick->getId()])
        ]);

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/trick/{id}/modifier", name="trick_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trick $trick, FileUploader $fileUploader, Security $security): Response
    {
        $form = $this->createForm(EditTrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUser($security->getUser());
            $trick->setUpdatedAt(new \DateTime());

            $pictureFiles = $trick->getPictureFiles();

            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

            foreach ($pictureFiles as $pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);

                $picture = new Picture();
                $picture->setURL($pictureFileName);
                $trick->addPicture($picture);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/trick/{id}", name="trick_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Trick $trick, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('deleteTrick', $request->request->get('_token'))) {
            $pictures = $trick->getPictures();

            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

            foreach ($pictures as $picture) {
                $fileUploader->remove($picture->getURL());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trick_index');
    }
}
