

<?php

class student extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('student/mescours', ['name' => $this->name]);
    }


}