<?php

    session_start();
    require_once '../classes/database.php';
    require_once '../classes/tags.php';


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['removeTag']) && !empty($_POST['removeTag'])){

        $getId = htmlspecialchars(trim($_POST['removeTag']));

        if(!empty($getId)){
            $instance = new tags();
            $return = $instance->deleteTag($getId,Database::getInstance()->getConnect());
            if($return === true){
                $_SESSION['alert'] = 'showAlert("success", "Tag removed successfuly!")';
                header('Location: ../view/admin/tags.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to remove tag!")';
                header('Location: ../view/admin/tags.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
            header('Location: ../view/admin/tags.php');
        }
        


    }else{
        $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
        header('Location: ../view/admin/tags.php');
    }









?>