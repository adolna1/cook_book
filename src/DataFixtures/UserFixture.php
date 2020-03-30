<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; ++$i) {
            $user = new User();
            $user->setEmail($i.'@example.pl');
            $user->setPassword($this->encoder->encodePassword($user, 'test'));
            $user->setFirstName('name'.$i);
            $user->setLastName('lastname'.$i);
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);

        }
        for ($i = 5; $i < 10; ++$i) {
            $user = new User();
            $user->setEmail($i.'@example.pl');
            $user->setPassword($this->encoder->encodePassword($user, 'test'));
            $user->setFirstName('name'.$i);
            $user->setLastName('lastname'.$i);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
