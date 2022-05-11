<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $user_admin= new User();
        $user=new User();

        $user_admin->setLogin('admin');
        $user_admin->setPassword($this->passwordEncoder->encodePassword($user_admin, 'qwe123'));
        $user_admin->setRoles(['ROLE_ADMIN']);

        $user->setLogin('user');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'qwe123'));

        $manager->persist($user_admin);
        $manager->persist($user);

        $manager->flush();
    }
}
