<?php

    
    session_start();

    require_once '../classes/database.php';
    require_once 'user.php';




    class admin extends user{



        public function __construct($status,$id_user,$nom,$prenom,$email,$password,$type)
        {
            parent::__construct($status,$id_user,$nom,$prenom,$email,$password,$type);
        }


        
    }