<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/picture")
 */
class PictureController extends AbstractController
{
    /**
     * @Route("/{id}/admin/modifier", name="picture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Picture $picture, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickId = $picture->getTrick()->getId();
            $pictureFile = $form->get('URL')->getData();
            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

            if ($pictureFile) {
                $oldURL = $picture->getURL();
                $pictureFileName = $fileUploader->upload($pictureFile);
                $picture->setURL($pictureFileName);
                $fileUploader->remove($oldURL);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trick_edit', ['id' => $trickId]);
        }

        return $this->render('picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/admin", name="picture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Picture $picture, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $request->request->get('_token'))) {
            $trickId = $picture->getTrick()->getId();

            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

            $fileName = $picture->getURL();

            $fileUploader->remove($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();

            return $this->json("Item deleted", 200);
        }

        return $this->json("Something, somewhere, went terribly wrong", 500);
    }
}
