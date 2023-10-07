<?php

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $table;

    public function __construct($table){
        $this->table = $table;
    }

    public function indexAction()
    {
        $tasks = $this->table->fetchAll();
        return new ViewModel(['tasks' => $tasks, 'paginator', $paginator]);
    }

    public function addAction(){
        $form = new \Task\Form\TaskForm;
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel(['form' => $form]);
        }

        $task = new \Task\Model\Task();
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            exit('Id is not correct');
        }
        
        $task->exchangeArray($form->getData());

        $message = $form->validateInputData($task);
        if ($message) {
            return new ViewModel([
                'form' => $form,
                'message' => $message
            ]);
        }

        $this->table->saveData($task);

        return $this->redirect()->toRoute('home',[
            'controller' => 'home',
            'action' => 'add',
            'message' => 'Operation Done Successfully'
        ]);

        return new ViewModel(['form' => $form]);
    }

    public function viewAction(){
        $id = (int) $this->params()->fromRoute('id');

        if ($id == 0) {
            exit("Error");
        }

        try {
            $task = $this->table->getTask($id);
        } catch (Exception $e) {
            exit('Error');
        }

        return new ViewModel([
            'task' => $task,
            'id' => $id
        ]);
    }

    public function editAction(){
        $id = (int) $this->params()->fromRoute('id');

        if ($id == 0) {
            exit("Error");
        }

        try {
            $task = $this->table->getTask($id);
        } catch (Exception $e) {
            exit('Error');
        }

        $form = new \Task\Form\TaskForm();
        $form->bind($task);
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ViewModel([
                'form' => $form,
                'id' => $id
            ]);
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            exit('Error');
        }

        $message = $form->validateInputData($task);
        if ($message) {
            return new ViewModel([
                'form' => $form,
                'message' => $message
            ]);
        }

        $this->table->saveData($task);

        return $this->redirect()->toRoute('home',[
            'controller' => 'edit',
            'action' => 'edit',
            'id' => $id
        ]);
    }

    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id');

        if ($id == 0) {
            exit("Error");
        }

        try {
            $task = $this->table->getTask($id);
        } catch (Exception $e) {
            exit('Error');
        }

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ViewModel([
                'task' => $task,
                'id' => $id
            ]);
        }

        $delete = $request->getPost('delete', 'No');
        if ($delete == 'Yes') {
            $id = (int) $task->getId();
            $this->table->deleteTask($id);
        }
        return $this->redirect()->toRoute('home');
    }

}
