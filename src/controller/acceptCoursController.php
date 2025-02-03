<?php


    session_start();
    require_once '../classes/database.php';
    require_once '../classes/cours.php';
    $instance = new cours();



    if($_SERVER['REQUEST_METHOD'] === "POST"){

        if(isset($_POST['accept']) && !empty($_POST['accept'])){
            $coursId = htmlspecialchars(trim($_POST['accept']));
            if(!empty($coursId)){
                $return = $instance->accepteCourse($coursId,Database::getInstance()->getConnect());
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "Course approved succefuly!")';
                    header('Location: ../view/admin/accepter.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to approve, try again!")';
                    header('Location: ../view/admin/accepter.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/accepter.php');
            }
        }elseif(isset($_POST['reject']) && !empty($_POST['reject'])){
            $coursId = htmlspecialchars(trim($_POST['reject']));
            if(!empty($coursId)){
                $return = $instance->rejectCourse($coursId,Database::getInstance()->getConnect());
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "Course rejected succefuly!")';
                    header('Location: ../view/admin/accepter.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to reject, try again!")';
                    header('Location: ../view/admin/accepter.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/accepter.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!!")';
            header('Location: ../view/admin/accepter.php');
        }
    }else{
        $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
        header('Location: ../view/admin/accepter.php');
    }





?>