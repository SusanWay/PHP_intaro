<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Book;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('rina');
        $user->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'QqQ123'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $book = new Book();
        $book->setName('Репка');
        $book->setContent('https://logomama.ru/res/Репка.pdf');
        $book->setPicture('http://www.tutsyk.ru/upload/iblock/66b/66b3605bcdb0361f002fc119d5e4c472.jpg');
        $book->setDateAdd(new \DateTime('now'));
        $book->setUser($user);
        $manager->persist($book);

        $user = new User();
        $user->setUsername('anna13');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'c6b2589d1'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $book = new Book();
        $book->setName('Племянник чародея');
        $book->setContent('https://vk.com/doc388023459_548773540?hash=TloVGJPShc26m7fHGlmk3T9yZUKPTZhot02gkXyLpAk&dl=TjG7ocbyhjGvJISvCR95bQfo7f93tKZMX1bAX9f6PAz');
        $book->setPicture('https://multi-boom.ru/upload/iblock/980/980033064cb852f9a94dd7f4c94df961.jpeg');
        $book->setDateAdd(new \DateTime('now'));
        $book->setUser($user);
        $manager->persist($book);

        $user = new User();
        $user->setUsername('serafim.demin');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'c789aad39'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $book = new Book();
        $book->setName('Принц Каспиан');
        $book->setContent('https://vk.com/doc388023459_548778703?hash=QCmouu2IAhDVdUfZi55hfQ9LxXLyKpM8lZTEEqhH5BP&dl=Gjg7z6poH9cvPh3kD0maZ1KQkd2DpjmRTMMzwRusYZ4');
        $book->setPicture('https://knigozor54.ru/upload/iblock/9b0/qgi85w70utgal05iea0xqk7n75j3dcfh.jpeg');
        $book->setDateAdd(new \DateTime('now'));
        $book->setUser($user);
        $manager->persist($book);

        $user = new User();
        $user->setUsername('tamara7269');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            '86fc73688'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $book = new Book();
        $book->setName('Серебряное кресло');
        $book->setContent('https://vk.com/doc388023459_548778787?hash=QpmvD8J0giF4BvB4IpaJZ321VJ4uju8CURq1l6mZEHX&dl=DITlfnp0XQdvNA2PAZXqIdESEZQSazC30IyKLr00f20');
        $book->setPicture('https://multi-boom.ru/upload/iblock/11e/11e1781f86cd9580f340b7f865d2aca3.jpeg');
        $book->setDateAdd(new \DateTime('now'));
        $book->setUser($user);
        $manager->persist($book);

        $manager->flush();
    }
}