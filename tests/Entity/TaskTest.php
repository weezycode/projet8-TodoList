<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{

    public function date()
    {
        return new DateTimeImmutable(date('23-05-2022 21:54'));
    }

    public function user()
    {
        return new User();
    }

    // set task entity 
    public function getEntityTest(): Task
    {
        return (new Task())
            ->setTitle('test Title')
            ->setContent('test content')
            ->toggle(false)
            ->setSlug('test-title')
            ->setUsers($this->user())
            ->setCreatedAt($this->date());
    }


    //get Error
    public function getErrorAssert(Task $task, int $nb = 0)
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());
        $error = self::getContainer()->get('validator')->validate($task);
        $this->assertCount($nb, $error);
    }


    //testing getter Title equal
    public function testGetTitle()
    {
        $this->assertEquals('test Title', $this->getEntityTest()->getTitle());
    }

    //testing getter content equal
    public function testGetContent()
    {
        $this->assertEquals('test content', $this->getEntityTest()->getContent());
    }

    //testing getter toggle isDone equal
    public function testGetToggleIsDone()
    {
        $this->assertEquals(false, $this->getEntityTest()->IsDone());
    }

    //testing getter slug equal
    public function testGetSlug()
    {
        $this->assertEquals('test-title', $this->getEntityTest()->getSlug());
    }

    //testing getter createdAt equal
    public function testGetCreatedAt(): void
    {
        $this->assertEquals($this->date(), $this->getEntityTest()->getCreatedAt());
    }

    //testing getter users
    public function testGetUsers()
    {
        $this->assertEquals($this->user(), $this->getEntityTest()->getUsers());
    }



    // test valid entity 
    public function testValidEntity()
    {
        $this->getErrorAssert($this->getEntityTest(), 0);
    }



    //testing user null
    public function testUserNull()
    {
        $this->getErrorAssert($this->getEntityTest()->setUsers(null), 0);
    }

    //testing invalid Assert Length title(min 5)
    public function testAssertLengthTitleEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setTitle('popo'), 1);
    }

    //test Assert NotBlank title
    public function testAssertNotBlankTitleEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setTitle('     '), 1);
    }

    //testing invalid title Pattern(/[a-zA-Z0-9._\p{L}-]{1,20}/)
    public function testInvalidAssertPatternTitleEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setTitle('######'), 1);
    }

    //testing invalid Assert Length content(min 10)
    public function testAssertLengthContentEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setContent('popo test'), 1);
    }

    //test Assert NotBlank title
    public function testAssertNotBlankContentEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setContent('           '), 1);
    }

    //testing invalid title Pattern(/[a-zA-Z0-9._\p{L}-]{1,20}/)
    public function testInvalidAssertPatternContentEntity()
    {
        $this->getErrorAssert($this->getEntityTest()->setContent('#############'), 1);
    }
}
