<?php
    namespace Task\Model;

    class Task
    {
        protected $id;
        protected $title;
        protected $description;
        protected $status;
        protected $created_at;
        protected $updated_at;

        public function getId(){
            return $this->id;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getDescription(){
            return $this->description;
        }

        public function getStatus(){
            return $this->status;
        }

        public function getCreatedAt(){
            return $this->created_at;
        }

        public function getUpdatedAt(){
            return $this->updated_at;
        }

        public function exchangeArray($data){
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->status = $data['status'];
            $this->created_at = $data['created_at'];
            $this->updated_at = $data['updated_at'];
        }

        public function getArrayCopy() {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }

    }
?>