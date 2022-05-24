<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use App\Service\MetaData;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private  $hasher;

    public function __construct(UserPasswordHasherInterface $hasher, private SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $data = new MetaData();
        foreach ($data->userData() as $userData) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setUsername($userData['username'])
                ->setEmail($userData['username'] . '@free.fr')
                ->setPassword($password)
                ->setRoles([$userData['roles']]);
            $this->setReference($userData['setUser'], $user);
            $manager->persist($user);
        }

        foreach ($data->taskData() as $taskData) {
            $task = new Task();
            $task->setTitle($taskData['title'])
                ->setContent($taskData['content'])
                ->setUsers($this->getReference($taskData['setUser']))
                ->setCreatedAt(new DateTimeImmutable())
                ->toggle($taskData['is_Done'])
                ->setSlug($this->slugger->slug($task->getTitle())->lower());
            $manager->persist($task);
        }
        for ($i = 1; $i < 5; $i++) {
            $anonymousTask = new Task();
            $anonymousTask->setTitle("task anonyme" . $i)
                ->setContent('content' . $i)
                ->setCreatedAt(new DateTimeImmutable())
                ->toggle(false)
                ->setUsers(null)
                ->setSlug($this->slugger->slug($anonymousTask->getTitle())->lower());
            $manager->persist($anonymousTask);
        }

        $manager->flush();
    }
}
