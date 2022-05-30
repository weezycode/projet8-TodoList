<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class UserTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     * 
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function task()
    {
        return new Task();
    }

    // set user entity test 
    public function getEntityTest(): User
    {
        return (new User())
            ->setEmail('testEntity@free.fr')
            ->setUsername('UserEntity')
            ->setPassword('Pass1$')
            ->setRoles(['ROLE_USER']);
    }



    // get error from user assert
    public function getErrorAssert(User $user, int $nb = 0)
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());
        $error = self::getContainer()->get('validator')->validate($user);
        $this->assertCount($nb, $error);
    }

    //testing Add Task
    public function testAddTask()
    {
        $this->getErrorAssert($this->getEntityTest()->addTask($this->task()), 0);
    }

    //testing Add Task
    public function testGetTask()
    {
        $this->assertNotFalse($this->getEntityTest()->getTasks());
    }

    //testing remove Task
    public function testRemoveTask()
    {
        $this->assertNotFalse($this->getEntityTest()->removeTask($this->task()));
    }


    //testing if object entity is valid
    public function testValidEntity()
    {
        $this->getErrorAssert($this->getEntityTest(), 0);
    }

    //testing invalid assert email
    public function testInvalidAssertEmailEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setEmail('invalidMail'), 1);
    }

    //testing when email is blank
    public function testInvalidAssertBlankEmailEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setEmail(''), 1);
    }

    //testing unique email(this user exist in database test)
    public function testInvalidUniqueEmailEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setEmail('Alpha@free.fr'), 1);
    }

    //testing unique username (this user exist in database test)
    public function testInvalidUniqueUsernameEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setUsername('Alpha'), 1);
    }

    //testing invalid pattern username(only letters)
    public function testInvalidAssertPatternUsernameEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setUsername('12345'), 1);
    }

    //testing invalid Blank username(not null)
    public function testInvalidAssertNotBlankUsernameEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setUsername(''), 1);
    }

    //testing invalid Length username(max 10)
    public function testInvalidAssertLengthUsernameEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setUsername('monPrenonDepasse'), 1);
    }

    //testing invalid password NotBlank
    public function testInvalidAssertNotBlankPasswordEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setPassword(''), 1);
    }

    //testing invalid Length password(min 5)
    public function testInvalidAssertLengthPasswordEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setPassword('Pa1$'), 1);
    }

    //testing invalid password Pattern(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$/)
    public function testInvalidAssertPatternPasswordEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setPassword('password'), 1);
    }
}
