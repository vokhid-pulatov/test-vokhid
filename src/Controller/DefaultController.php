<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TaskService;
use Symfony\Component\HttpFoundation\RequestStack;

class DefaultController extends AbstractController
{
    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(RequestStack $requestStack, TaskService $taskService)
    {
        $this->taskService = $taskService;

    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function taskList()
    {
        $tasks = $this->taskService->getAllTasks();

        return $this->render('task_list.html.twig', [
            'tasks' =>$tasks
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addTask(Request $request)
    {
        $result = $this->taskService->addTask($request->get('task_name'));
        $tasks = $this->taskService->getAllTasks();
        $task_list = $this->render('tasks.html.twig', [
            'tasks' =>$tasks
        ])->getContent();
        return new Response(
            json_encode([
                'success'=>true,
                'errors'=>[],
                'html'=>$task_list])
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editTask(Request $request)
    {
        $result = $this->taskService->editTask($request->get('task_name'), $request->get('task_id'));
        $tasks = $this->taskService->getAllTasks();
        $task_list = $this->render('tasks.html.twig', [
            'tasks' =>$tasks
        ])->getContent();
        return new Response(
            json_encode([
                'success'=>true,
                'errors'=>[],
                'html'=>$task_list])
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteTask(Request $request)
    {
        $result = $this->taskService->deleteTask($request->get('task_id'));
        $tasks = $this->taskService->getAllTasks();
        $task_list = $this->render('tasks.html.twig', [
            'tasks' =>$tasks
        ])->getContent();
        return new Response(
            json_encode([
                'success'=>true,
                'errors'=>[],
                'html'=>$task_list])
        );
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }


}