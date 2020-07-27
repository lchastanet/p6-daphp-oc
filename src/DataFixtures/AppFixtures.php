<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\Trick;
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
        $user = new User();
        $user->setUserName('john')
            ->setEmail('hello@john.doe')
            ->setPassword($this->encoder->encodePassword($user, 'azerty'))
            ->setAvatar('default/default-avatar.jpg');

        $manager->persist($user);

        $groupe = new Groupe();

        $groupe->setName('grabs');

        $manager->persist($groupe);

        $groupe = new Groupe();

        $groupe->setName('rotations');

        $manager->persist($groupe);

        $groupe = new Groupe();

        $groupe->setName('flips');

        $manager->persist($groupe);

        $trick = new Trick();

        $trick->setTitle('mute')
            ->setDescription('Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        $trick = new Trick();

        $trick->setTitle('sad')
            ->setDescription('Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        $trick = new Trick();

        $trick->setTitle('indy')
            ->setDescription('Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.')
            ->setGroupe($groupe)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $manager->persist($trick);

        $manager->flush();
    }
}
