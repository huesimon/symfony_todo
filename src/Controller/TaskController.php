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
		
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
	}
	/**
     * @Route("/task/save", name="save")
     */
	public function saveTask() {
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
}
