<?php

        session_start();
        require_once '../app/models/database.php';
        require_once '../app/models/tags.php';


    class tagsCont{

        public function ajouteTagAction(){
        
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addTag'])){
        
                $getName = htmlspecialchars(trim($_POST['tag_name']));
        
                if(!empty($getName)){
                    $instance = new tags(null,$getName);
                    $instance->addTags(Database::getInstance()->getConnect());
                    if($instance != false){
                        $_SESSION['alert'] = 'showAlert("success", "Tag added successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }else{
                        $_SESSION['alert'] = 'showAlert("success", "Faild to add tag!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }
        
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/tags');
                }
        
        
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/admin/tags');
            }
        }

        public function editTagAction(){
        
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit']) && !empty($_POST['edit'])){
        
                $getId = htmlspecialchars(trim($_POST['edit']));
                $getName = htmlspecialchars(trim($_POST['editTagName']));
        
                if(!empty($getId) && !empty($getName)){
                    $instance = new tags($getId,$getName);
                    $return = $instance->addTags(Database::getInstance()->getConnect());
                    if($return === true){
                        $_SESSION['alert'] = 'showAlert("success", "Tag edited successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to edit tag!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/tags');
                }
                
        
        
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/admin/tags');
            }
        }


        public function removeTagAction(){
        
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['removeTag']) && !empty($_POST['removeTag'])){
        
                $getId = htmlspecialchars(trim($_POST['removeTag']));
        
                if(!empty($getId)){
                    $instance = new tags();
                    $return = $instance->deleteTag($getId,Database::getInstance()->getConnect());
                    if($return === true){
                        $_SESSION['alert'] = 'showAlert("success", "Tag removed successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to remove tag!")';
                        header('Location: http://localhost/youdemy2/public/admin/tags');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/tags');
                }
                
        
        
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/admin/tags');
            }
        }
    }





?>