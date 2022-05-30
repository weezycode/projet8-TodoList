<?php

namespace App\Tests\Controller;

use Exception;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful(string $url)
    {
        $client = static::createClient();
        /** 
         * @var \App\Repository\UserRepository $userRepository
         * 
         */

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'Alpha']);

        if (!$testUser instanceof UserInterface) {
            throw new Exception("Pas de Logger", 1);
        }
        $client->loginUser($testUser);

        //$client->catchExceptions(false);
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/login'];
        yield ['/tasks'];
        yield ['/tasks/reunion/edit'];
        yield ['/tasks/create'];
        yield ['/tasks/todo'];
        yield ['/tasks/done'];
        yield ['/users/create'];
        yield ['/users'];
        yield ['/users/Alpha/edit'];
        // ...
    }
}
