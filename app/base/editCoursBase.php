


<?php

    session_start();
    require_once '../classes/cours.php';
    require_once '../classes/database.php';
    $callCourse = new cours();


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_course']) && !empty($_POST['edit_course']) && isset($_SESSION['id'])){

        $getCourseId = htmlspecialchars(trim($_POST['edit_course']));
        $getTitre = htmlspecialchars(trim($_POST['edit_title']));
        $getDesc = htmlspecialchars(trim($_POST['edit_description']));
        if(!empty($getCourseId) && !empty($getTitre) && !empty($getDesc)){
            $getReturn = $callCourse->editCour($getTitre,$getDesc,$getCourseId,$_SESSION['id'],Database::getInstance()->getConnect());
            if($getReturn === true){
                $_SESSION['alert'] = 'showAlert("success", "Course edited succefuly!")';
                header('Location: ../view/teacher/cours.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to edit the course!")';
                header('Location: ../view/teacher/cours.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
            header('Location: ../view/teacher/cours.php');
        }
        
    }else{
        $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
        header('Location: ../view/teacher/cours.php');
    }















?>