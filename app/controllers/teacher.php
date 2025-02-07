

<?php

class teacher extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('home/index', ['name' => $this->name]);
    }

    public function dashboard($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('teacher/dashboard', ['name' => $this->name]);
    }

    public function cours($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('teacher/cours', ['name' => $this->name]);
    }

    public function students($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('teacher/students', ['name' => $this->name]);
    }

}