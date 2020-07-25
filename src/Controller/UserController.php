<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserType;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Form\PictureType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Security;
use App\Service\FileUploader;



class UserController extends AbstractController
{
    /**
     * @Route("/connexion", name="user_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $user = new User();

        return $this->render('user/login.html.twig', [
            'user' => $user,
            'error' => $error
        ]);
    }

    /**
     * @Route("/inscription", name="user_registration", methods={"GET","POST"})
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $user->setAvatar('default/default-avatar.jpg');
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mot-de-passe-oublie", name="user_forgot_password", methods={"GET","POST"})
     */
    public function forgotPassword(Request $request, EntityManagerInterface $manager, MailerInterface $mailer)
    {
        $user = new User();

        $form = $this->createForm(ForgotPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $manager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($user) {
                $user->setReinitToken(bin2hex(random_bytes(32)));

                $manager->persist($user);
                $manager->flush();

                $email = (new Email())
                    ->from('mailer@oc-projet5.loris.space')
                    ->to($user->getEmail())
                    ->subject('Réinitialisez votre mot de passe!')
                    ->text('http://localhost:8000/reinitialiser-mot-de-passe?user=' . $user->getUserName() . '&token=' . $user->getReinitToken());

                $mailer->send($email);

                return $this->redirectToRoute('user_login');
            }

            return $this->redirectToRoute('user_registration');
        }

        return $this->render('user/forgot_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reinitialiser-mot-de-passe", name="user_reset_password", methods={"GET","POST"})
     */
    public function resetPassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $userName = $request->query->get('user');
        $token = $request->query->get('token');

        $user = $manager->getRepository(User::class)->findOneBy(['userName' => $userName]);

        if ($token == $user->getReinitToken()) {
            $form = $this->createForm(ResetPasswordType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                $user->setReinitToken(null);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Un email vous à été envoyer, cliquez sur le lien pour réinitialiser votre mot de passe!');

                return $this->redirectToRoute('user_login');
            }

            return $this->render('user/reset_password.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('danger', 'Le lien est invalide ou à expiré!');

        return $this->redirectToRoute('trick_index');
    }

    /**
     * @Route("/admin/modifier-avatar", name="user_edit_avatar", methods={"GET","POST"})
     */
    public function edit(Request $request, Security $security, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        $user = $manager->getRepository(User::class)->findOneBy(['userName' => $security->getUser()->getUsername()]);

        $form = $this->createForm(PictureType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureFile = $form->get('URL')->getData();

            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/avatars');

            if (!preg_match('#default\/default#', $user->getAvatar())) {
                $fileUploader->remove($user->getAvatar());
            }

            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $user->setAvatar($pictureFileName);
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_edit_avatar');
        }

        return $this->render('user/edit_avatar.html.twig', [
            'currentAvatar' => $user->getAvatar(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/supprimer-avatar", name="user_delete_avatar", methods={"DELETE"})
     */
    public function deleteAvatar(Request $request, Security $security, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        $user = $manager->getRepository(User::class)->findOneBy(['userName' => $security->getUser()->getUsername()]);


        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $fileUploader->setTargetDirectory($fileUploader->getTargetDirectory() . '/avatars');

            if (!preg_match('#default\/default#', $user->getAvatar())) {
                $fileUploader->remove($user->getAvatar());
                $user->setAvatar('default/default-avatar.jpg');

                $manager->persist($user);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('user_edit_avatar');
    }

    /**
     * @Route("/deconnexion", name="user_logout")
     */
    public function logout()
    {
    }
}
