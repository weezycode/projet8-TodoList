<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use Exception;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{


    public function testGetAction()
    {
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneBy(['title' => 'Moudou']);
        $this->assertNotFalse($task);
        return $task;
    }

    public function testLogger()
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $this->assertNotFalse($userRepository);
        return $userRepository->findOneBy(['username' => 'Alpha']);
    }

    public function testCreateAction(): void
    {
        $client = static::createClient();


        // simulate $testUser being logged in
        $client->loginUser($this->testLogger());
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => 'Moudou',
            'task[content]' => 'Contacter toute l\'équipe',
        ]);
        $crawler = $client->submit($form);

        $client->followRedirect();
        $this->assertStringContainsString('Moudou', '' . $client->getResponse()->getContent());
        $task = $this->testGetAction(['slug' => 'moudou']);
        $this->assertNotFalse($task->getCreatedAt());
        $this->assertEquals('Moudou', $task->getTitle());
    }

    public function testEditAction()
    {
        $client = static::createClient();

        // simulate $testUser being logged in
        $client->loginUser($this->testLogger());
        $crawler = $client->request('GET', '/tasks/moudou/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Modifier', '' . $client->getResponse()->getContent());

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'Moudou modifié',
            'task[content]' => 'Contacter toute l\'équipe',
        ]);
        $crawler = $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString('Moudou modifié', '' . $client->getResponse()->getContent());
    }

    public function testToggleActionDone()
    {
        $client = static::createClient();

        // simulate $testUser being logged in
        $client->loginUser($this->testLogger());
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Marquer comme faite')->eq(1)->form();
        $crawler = $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString('a bien été marquée comme faite', '' . $client->getResponse()->getContent());
    }

    public function testToggleActionNotDone()
    {

        $client = static::createClient();

        // simulate $testUser being logged in
        $client->loginUser($this->testLogger());
        $crawler = $client->request('GET', '/tasks');

        $form = $crawler->selectButton('Marquer non terminée')->eq(0)->form();
        $crawler = $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString(' a bien été marquée comme non faite', '' . $client->getResponse()->getContent());
    }


    public function testDeleteAction()
    {
        $client = static::createClient();

        // simulate $testUser being logged in
        $client->loginUser($this->testLogger());
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Supprimer')->eq(2)->form();
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirection());

        $client->followRedirect();
        $this->assertStringContainsString('La tâche a bien été supprimée.', '' . $client->getResponse()->getContent());
    }
}
