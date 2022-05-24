<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use Exception;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskControllerTest extends WebTestCase
{


    public function testGetAction()
    {
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneBy(['title' => 'Moudou']);
        $this->assertNotFalse($task->getTitle());
        return $task;
    }

    public function testCreateAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'Alpha']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Moudou',
            'task[content]' => 'Contacter toute l\'équipe',
        ]);
        $crawler = $client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Moudou', '' . $client->getResponse()->getContent());
        $task = $this->testGetAction(['slug' => 'moudou']);
        $this->assertNotFalse($task->getCreatedAt());
        $this->assertEquals('Moudou', $task->getTitle());
    }
}
