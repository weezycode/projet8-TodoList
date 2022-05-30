<?php

declare(strict_types=1);

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPersister extends AbstractController
{
    private $em;
    private $passwordHasher;
    public function __construct(ManagerRegistry $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em->getManager();
        $this->passwordHasher = $passwordHasher;
    }

    public function addUser(FormInterface $form, User $user)
    {

        $plainPassword = $form->get('password')->getData();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        $this->em->persist($user);
        $this->em->flush();
    }
}
