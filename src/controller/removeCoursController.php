




<?php



    session_start();
    require_once '../classes/cours.php';
    require_once '../classes/database.php';
    $callCourse = new cours();

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['remove']) && !empty($_POST['remove']) && isset($_SESSION['id'])){

        $coursId = htmlspecialchars(trim($_POST['remove']));
        if(!empty($coursId)){

            $getReturn = $callCourse->removeCour($coursId,$_SESSION['id'],Database::getInstance()->getConnect());
            if($getReturn === true){
                $_SESSION['alert'] = 'showAlert("success", "Course removed successfuly!")';
                header('Location: ../view/teacher/cours.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to remove course, Try again!")';
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