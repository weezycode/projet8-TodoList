<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/inscription", name ="security_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepo): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('show_tricks');
        }

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            $userRepo->add($user);
            $this->addFlash('success', 'Votre inscription a été bien prise en compte, veuillez valider votre compte en cliquant sur le lien qui vous a été envoyé par email !');

            return $this->redirectToRoute('show_tricks');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name ="security_login")
     */

    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser()) {
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name ="security_logout")
     */

    public function logout()
    {
        throw new \Exception('This should never be reached!');
    }
}
