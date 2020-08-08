<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Video;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setUserName('jimmy')
            ->setEmail('hello@jimmy.sweat')
            ->setPassword($this->encoder->encodePassword($user, 'azerty'))
            ->setAvatar('default/default-avatar.jpg');

        $manager->persist($user);

        $groupe = new Groupe();
        $groupe->setName('grabs');

        $manager->persist($groupe);

        $trick = new Trick();
        $trick->setTitle('mute')
            ->setDescription('Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('mute_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('mute_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('mute_3.jpg');

        $manager->persist($picture);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xgnktg');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x4en41');

        $manager->persist($video);

        $trick = new Trick();
        $trick->setTitle('sad')
            ->setDescription('Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x1op6a');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('sad_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('sad_2.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('indy')
            ->setDescription('Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x11jh6u');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x80rjl');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x6ul2u');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('indy_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('indy_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('indy_3.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('stalefish')
            ->setDescription('Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x3vpy');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x78ic0v');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('stalefish_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('stalefish_2.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('truck driver')
            ->setDescription('Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('truck_driver_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('truck_driver_2.jpg');

        $manager->persist($picture);

        $groupe = new Groupe();
        $groupe->setName('rotations');

        $manager->persist($groupe);

        $trick = new Trick();
        $trick->setTitle('360, trois six pour un tour complet')
            ->setDescription('Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x3ldx3');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xgdm2s');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xclzuz');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('360_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('360_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('360_3.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('540, cinq quatre pour un tour et demi')
            ->setDescription('Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xgdlde');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xjkiw');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('540_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('540_2.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('720, sept deux pour deux tours complets')
            ->setDescription('Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x5mpuq');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('720_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('720_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('720_3.jpg');

        $manager->persist($picture);

        $groupe = new Groupe();
        $groupe->setName('flips');

        $manager->persist($groupe);

        $trick = new Trick();
        $trick->setTitle('front flip')
            ->setDescription('Rotation verticale, en avant.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xe579v');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x2m9xem');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('front_flip_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('front_flip_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('front_flip_3.jpg');

        $manager->persist($picture);

        $trick = new Trick();
        $trick->setTitle('back flip')
            ->setDescription('Rotation verticale, en arrière.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        for ($i = 0; $i < 7; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setTrick($trick)
                ->setContent($faker->realText(200, 1));

            $manager->persist($comment);
        }

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x19b6ui');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/x4z1iy');

        $manager->persist($video);

        $video = new Video();
        $video->setTrick($trick)
            ->setURL('https://www.dailymotion.com/embed/video/xh94s2');

        $manager->persist($video);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('back_flip_1.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('back_flip_2.jpg');

        $manager->persist($picture);

        $picture = new Picture();
        $picture->setTrick($trick)
            ->setURL('back_flip_3.jpg');

        $manager->persist($picture);

        $manager->flush();
    }
}
