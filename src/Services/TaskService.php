<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class TaskService
{
    public function __construct(ContainerInterface $container, EntityManagerInterface $em)
    {
        $this->_container = $container;
        $this->_em = $em;
    }

    public function getAllTasks()
    {
        $tasks = $this->_em->createQuery(
        'SELECT t
             FROM
                App\Entity\Task t
             WHERE
               t.is_deleted IS NULL or t.is_deleted != 1'
        )->getResult();
        return $tasks;
    }

    public function addTask($task_name)
    {
        $task = new Task();
        $task->setTask($task_name);
        $task->getIsDone(1);
        $task->setCreated(new \DateTime());
        $task->setModified(new \DateTime());
        $this->_em->persist($task);
        $this->_em->flush();
    }

    public function editTask($task_name, $task_id)
    {
        $task = $task = $tasks = $this->_em->createQuery(
            'SELECT t
             FROM
                App\Entity\Task t
             WHERE
               t.id = :id'
        ) ->setParameters(['id'=>$task_id])->getSingleResult();
        $task->setTask($task_name);
        $task->setModified(new \DateTime());
        $this->_em->persist($task);
        $this->_em->flush();
    }

    public function deleteTask($task_id)
    {
        $task = $this->_em->createQuery(
            'SELECT t
             FROM
                App\Entity\Task t
             WHERE
               t.id = :id'
        ) ->setParameters(['id'=>$task_id])->getSingleResult();
        $task->setIsDeleted(1);
        $task->setModified(new \DateTime());
        $this->_em->persist($task);
        $this->_em->flush();
    }
}