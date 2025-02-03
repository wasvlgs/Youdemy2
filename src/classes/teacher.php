<?php

    

    require_once 'user.php';




    class prof extends user{



        public function __construct($status,$id_user,$nom,$prenom,$email,$password,$type)
        {
            parent::__construct($status,$id_user,$nom,$prenom,$email,$password,$type);
        }


        public static function getBestTeacher($conn){
            $getBestTeacher = $conn->prepare("SELECT users.id_user,nom,prenom,COUNT(mycours.id_user) AS total FROM users INNER JOIN cours ON users.id_user = cours.id_user INNER JOIN mycours ON cours.id_cours = mycours.id_cours GROUP BY users.id_user ORDER BY total LIMIT 3");
            if($getBestTeacher->execute()){
                return $getBestTeacher;
            }else{
                return null;
            }
        }
        
    }