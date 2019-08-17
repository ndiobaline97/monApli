<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SuperadminFixtures extends Fixture
{
    
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('ndioba');
    
        $password = $this->encoder->encodePassword($user, 'pass_1234');
        $user->setPassword($password);

        $user->setStatut('actif');
        $user->setImageName("jkhjhj.jpg");
        $user->setUpdatedAt(new \DateTime());
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->getPartenaire();

        $manager->persist($user);
        $manager->flush();
    }
}

