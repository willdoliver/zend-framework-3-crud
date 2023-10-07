<?php
    namespace Task\Model;

    use Zend\Db\TableGateway\TableGatewayInterface;

    class TaskTable
    {
        protected $tableGateway;

        function __construct(TableGatewayInterface $tableGateway)
        {
            $this->tableGateway = $tableGateway;
        }

        public function fetchAll(){
            return $this->tableGateway->select();
        }

        public function saveData($task) {
            $data = [
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus()
            ];

            if ($task->getId()) {
                $data['updated_at'] = date("Y-m-d H:i:s");
                $this->tableGateway->update($data, [
                    'id' => $task->getId()
                ]);
            } else {
                $data['created_at'] = date("Y-m-d H:i:s");
                return $this->tableGateway->insert($data);
            }
        }

        public function getTask($id) {
            $data = $this->tableGateway->select([
                'id' => $id
            ]);
            return $data->current();
        }

        public function deleteTask($id) {
            $this->tableGateway->delete([
                'id' => $id
            ]);
        }

    }
?>