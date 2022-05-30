<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use DateTimeImmutable;
use Doctrine\ORM\Query\Expr\Func;
use PhpParser\Node\Expr\FuncCall;
use App\Repository\TaskRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    private $taskRepository;
    private $em;
    public function __construct(TaskRepository $taskRepository, ManagerRegistry $em, private SluggerInterface $slugger)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em->getManager();
    }
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render("task/list.html.twig", [
            'tasks' => $this->taskRepository->findAll(['createdAt' => 'DESC'])
        ],);
    }
    /**
     * @Route("/tasks/todo", name="task_todo")
     */
    public function listToDo()
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $this->taskRepository->findBy(['isDone' => false], ['createdAt' => 'desc']),
        ]);
    }

    /**
     * @Route("/tasks/done", name="task_done")
     */
    public function listDone()
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $this->taskRepository->findBy(['isDone' => true], ['createdAt' => 'desc']),
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $user = $this->getUser();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUsers($user)
                ->toggle(false)
                ->setCreatedAt(new DateTimeImmutable())
                ->setSlug($this->slugger->slug($task->getTitle())->lower());
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tasks/{slug}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUsers($user)
                ->toggle(false)
                ->setCreatedAt(new DateTimeImmutable())
                ->setSlug($this->slugger->slug($task->getTitle())->lower());
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('success', 'La tâche a été bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->em->flush();
        if ($task->isDone()) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
        } else {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non faite.', $task->getTitle()));
        }
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {

        $this->denyAccessUnlessGranted('delete', $task);

        $this->em->remove($task);
        $this->em->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
