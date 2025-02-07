

<?php

class login extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('login/login', ['name' => $this->name]);
    }

}