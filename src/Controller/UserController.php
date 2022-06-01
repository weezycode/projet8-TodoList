<?php

declare(strict_types=1);

namespace App\Controller;

use App\DataPersister\UserPersister;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    private $em;
    private $userRepository;
    private $persister;
    public function __construct(ManagerRegistry $em, UserRepository $userRepository, UserPersister $persister)
    {
        $this->em = $em->getManager();
        $this->userRepository = $userRepository;
        $this->persister = $persister;
    }

    /**
     * @Route("/users", name = "user_list")
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render("users/list.html.twig", [
            "users" => $this->userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persister->addUser($form, $user);
            $this->addFlash('success', 'L\'utilisateur a été bien ajouté !');
            return $this->redirectToRoute('user_list');
        }
        return $this->render('users/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{username}/edit", name="user_edit")
     */
    public function editAction(Request $request, $username)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->userRepository->findOneBy(['username' => $username]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persister->addUser($form, $user);
            $this->addFlash('success', 'L\'utilisateur a été bien modifié !');
            return $this->redirectToRoute('user_list');
        }
        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
