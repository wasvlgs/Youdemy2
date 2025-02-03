<?php

    session_start();
    require_once '../classes/database.php';
    require_once '../classes/tags.php';


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addTag'])){

        $getName = htmlspecialchars(trim($_POST['tag_name']));

        if(!empty($getName)){
            $instance = new tags(null,$getName);
            $instance->addTags(Database::getInstance()->getConnect());
            if($instance != false){
                $_SESSION['alert'] = 'showAlert("success", "Tag added successfuly!")';
                header('Location: ../view/admin/tags.php');
            }else{
                $_SESSION['alert'] = 'showAlert("success", "Faild to add tag!")';
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