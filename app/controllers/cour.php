

<?php

class cour extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('cour', ['name' => $this->name]);
    }

}