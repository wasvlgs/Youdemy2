<?php





    class Controller{

        protected $name;

        public function model($model){
            require_once '../app/models/'.$model.'.php';
            return new $model();
        }

        public function view($view,$data = []){
            require_once '../app/view/'. $view .'.php';
        }
    }