

    <?php

        class Home extends Controller{



            public function index($name = ''){
                $this->model('user');
                $this->name = $name;
                
                $this->view('home/index', ['name' => $this->name]);
            }

        }