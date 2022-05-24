<?php

namespace Tests\Controller;

use Exception;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityControllerTest extends WebTestCase
{


    public function testLogout(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'Alpha']);
        if (!$testUser instanceof UserInterface) {
            throw new Exception("Il n'y a pas de user de test pour se connecter", 1);
        }

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Se déconnecter')->link();
        $client->click($link);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('Se connecter', '' . $client->getResponse()->getContent());
    }

    public function testLogin(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'Alpha',
            '_password' => 'pass_1234',
        ]);

        $crawler = $client->submit($form);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Se déconnecter', '' . $client->getResponse()->getContent());
    }
}
