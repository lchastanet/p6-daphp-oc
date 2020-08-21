<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/picture")
 */
class PictureController extends AbstractController
{
    /**
     * @Route("/{id}/admin/modifier", name="picture_edit", methods={"POST"})
     */
    public function edit(Request $request, Picture $picture, FileUploader $fileUploader, ValidatorInterface $validator): Response
    {
        $newPicture = $request->files->get('picture');

        $violations = $validator->validate(
            $newPicture,
            new File([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'image/*',
                ]
            ])
        );

        if ($violations->count() > 0) {
            $violation = $violations[0];

            return $this->json($violation->getMessage(), 403);
        }

        $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/pictures');

        $oldURL = $picture->getURL();
        $pictureFileName = $fileUploader->upload($newPicture);
        $picture->setURL($pictureFileName);
        $fileUploader->remove($oldURL);

        $this->getDoctrine()->getManager()->flush();

        return $this->json($pictureFileName, 200);
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
