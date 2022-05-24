<?php

namespace App\Tests\Controller;

use Exception;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'Alpha']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $crawler = $client->request('GET', '/users/create');
        //get Rôles
        $userRoles = $testUser->getRoles();
        $this->assertContains('ROLE_ADMIN', $userRoles, 'L\'utilisateur n\'est pas Admin !');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[email]' => 'Bravo@free.fr',
            'user[username]' => 'Bravo',
            'user[password][first]' => 'pass_1234',
            'user[password][second]' => 'pass_1234',
            'user[roles]' => 'ROLE_ADMIN',
        ]);
        $client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Bravo', '' . $client->getResponse()->getContent());
    }

    public function testEditAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'Alpha']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $crawler = $client->request('GET', '/users/Bravo/edit');
        //get Rôles
        $userRoles = $testUser->getRoles();
        $this->assertContains('ROLE_ADMIN', $userRoles, 'L\'utilisateur n\'est pas Admin !');
        $form = $crawler->selectButton('Modifier')->form([
            'user[email]' => 'Bravo@free.fr',
            'user[username]' => 'Bravo',
            'user[password][first]' => 'pass_1234',
            'user[password][second]' => 'pass_1234',
            'user[roles]' => 'ROLE_USER',
        ]);
        $client->submit($form);
        $this->assertResponseIsSuccessful();
        $client->request('GET', '/users');
        $this->assertStringContainsString('Bravo', '' . $client->getResponse()->getContent());
    }
}
