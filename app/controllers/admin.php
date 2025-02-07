

<?php

class admin extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('home/index', ['name' => $this->name]);
    }

    public function dashboard($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('admin/dashboard', ['name' => $this->name]);
    }

    public function accepter($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('admin/accepter', ['name' => $this->name]);
    }

    public function users($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('admin/users', ['name' => $this->name]);
    }

    public function tags($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('admin/tags', ['name' => $this->name]);
    }

}