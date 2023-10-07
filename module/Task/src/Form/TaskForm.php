<?php
    namespace Task\Form;

    use Zend\Form\Form;

    class TaskForm extends Form
    {
        function __construct($name = null) {
            parent::__construct('task');
            $this->setAttribute('method', 'POST');

            $this->add([
                'name' => 'id',
                'type' =>  'hidden'
            ]);

            $this->add([
                'name' => 'title',
                'type' =>  'text',
                'options' => [
                    'label' => 'Title'
                ]
            ]);

            $this->add([
                'name' => 'description',
                'type' =>  'textarea',
                'options' => [
                    'label' => 'Description'
                ]
            ]);

            $this->add([
                'name' => 'status',
                'type' =>  'select',
                'options' => [
                    'label' => 'Status',
                    'empty_option' => 'Select Status',
                    'value_options' => [
                        'Pending' => 'Pending',
                        'Completed' => 'Completed',
                    ]
                ]
            ]);

            $this->add([
                'name' => 'submit',
                'type' =>  'submit',
                'attributes' => [
                    'value' => 'Save',
                    'id' => 'buttonSave',
                ]
            ]);
        }

        public function validateInputData($task) {
            $valid = '';

            if (strlen(trim($task->getTitle())) < 1){
                return "Please Check Title";
            }

            if (strlen(trim($task->getDescription())) < 1){
                return "Please Check Description";
            }

            if (strlen(trim($task->getStatus())) < 1){
                return "Please Check Status";
            } else {
                $status = trim($task->getStatus());
                if (!in_array($status, ['Pending', 'Completed'])) {
                    return "Please Check Status Option";
                }
            }

            return $valid;
        }
    }

?>