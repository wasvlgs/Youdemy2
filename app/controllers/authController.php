<?php


            require_once '../app/models/database.php';
            require_once '../app/models/user.php';
            require_once '../app/models/student.php';
            require_once '../app/models/teacher.php';


    class authController extends Controller{


        public function loginAction(){
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['loginSubmit'])){

                $getEmail = htmlspecialchars(trim($_POST['getEmail']));
                $getPass = htmlspecialchars(trim($_POST['getPass']));
        
                if(!empty($getEmail) && !empty($getPass)){
                    user::login($getEmail,$getPass,Database::getInstance()->getConnect());
                }else{
                    session_start();
                    $_SESSION['logError'] = "Ivalid information";
                    header("Location: http://localhost/youdemy2/public/login");
                }
            }
        }

        public function signupAction(){
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signupSubmit'])){
        
        
                $getFName = htmlspecialchars(trim($_POST['setFName']));
                $getLName = htmlspecialchars(trim($_POST['setLName']));
                $getEmail = htmlspecialchars(trim($_POST['setEmail']));
                $getPass = htmlspecialchars(trim($_POST['setPass']));
                $getType = htmlspecialchars(trim($_POST['setType']));
        
                if(!empty($getFName) && !empty($getLName) && !empty($getEmail) && !empty($getPass) && !empty($getType)){
                    if($getType === "etudiant"){
                        $role = 'active';
                        $instance = new etudiant($role,null,$getLName,$getFName,$getEmail,$getPass,3);
                        $instance->signup('student',Database::getInstance()->getConnect());
                    }else if($getType === "prof"){
                        $role = 'pending';
                        $instance = new prof($role,null,$getLName,$getFName,$getEmail,$getPass,2);
                        $instance->signup('teacher',Database::getInstance()->getConnect());
                    }else{
                        session_start();
                        $_SESSION['Error'] = "Invalid information";
                        header("Location: http://localhost/youdemy2/public/login");
                    }
                }else{
                    session_start();
                    $_SESSION['Error'] = "Invalid information";
                    header("Location: http://localhost/youdemy2/public/login");
                }
            }
        }
    }









?>