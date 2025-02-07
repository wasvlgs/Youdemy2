

<?php

class Catalogue extends Controller{



    public function index($name = ''){
        $this->model('user');
        $this->name = $name;
        
        $this->view('catalogue', ['name' => $this->name]);
    }

}