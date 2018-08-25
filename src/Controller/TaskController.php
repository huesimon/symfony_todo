<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
	 * @Route("/")
     */
    public function index() {
		$tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
	}
	
	/**
	 * @Route("/task/{id}/complete")
	 */
	public function markAsComplete($id) {
		$entityManager =$this->getDoctrine()->getManager();
		$task = $this->getDoctrine()->getRepository(Task::class)->find($id);
		
		$task->setStatus(true);		
		$entityManager->flush();
		
		return $this->redirectToRoute('task');
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

	/**
     * @Route("/task/new", name="new")
     */
	public function newTask(Request $request) {
		$entityManager =$this->getDoctrine()->getManager();	
		$task = new Task(); 
		//TODO: Add user to the task
		$task->setUserId(0);
		$task->setStatus(false);
		$form = $this->createFormBuilder($task)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$task = $form->getData();

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($task);
			$entityManager->flush();

			return $this->redirectToRoute('task');
		}
			
		return $this->render('task/new.html.twig', array(
			'form' => $form->createView(),
		));
	}


}


