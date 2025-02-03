<?php

    session_start();
    require_once '../classes/database.php';
    require_once '../classes/tags.php';


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit']) && !empty($_POST['edit'])){

        $getId = htmlspecialchars(trim($_POST['edit']));
        $getName = htmlspecialchars(trim($_POST['editTagName']));

        if(!empty($getId) && !empty($getName)){
            $instance = new tags($getId,$getName);
            $return = $instance->addTags(Database::getInstance()->getConnect());
            if($return === true){
                $_SESSION['alert'] = 'showAlert("success", "Tag edited successfuly!")';
                header('Location: ../view/admin/tags.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to edit tag!")';
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