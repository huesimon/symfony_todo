<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Task;
class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index() {
		$tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
	}
	
	/**
     * @Route("/task/save/test", name="saveTaskTest")
     */
	public function saveTaskTest() {
		$entityManager =$this->getDoctrine()->getManager();
		$task = new Task();
		$task->setName('test');
		$task->setStatus(false);
		$task->setUserId(0);

		$entityManager->persist($task);
		
        $entityManager->flush();

		

        return new Response('Saved new task with id '.$task->getId() . ' and task name:' . $task->getName());

	}
	//✅

	/**
     * @Route("/task/save", name="save")
     */
	public function saveTask($title) {
		$entityManager =$this->getDoctrine()->getManager();
		$task = new Task();
		$task->setName('test');
		$task->setStatus(false);
		$task->setUserId(0);

		$entityManager->persist($task);
		
        $entityManager->flush();

		

        return new Response('Saved new task with id '.$task->getId() . ' and task name:' . $task->getName());

	}


}


