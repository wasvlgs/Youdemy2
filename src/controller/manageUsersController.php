<?php


    session_start();
    require_once '../classes/database.php';
    require_once '../classes/user.php';

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_SESSION['id'])){
        $db = Database::getInstance()->getConnect();
        $instance = new user();

        if(isset($_POST['block']) && !empty($_POST['block'])){
            $getID = htmlspecialchars(trim($_POST['block']));
            if(!empty($getID)){
                $return = $instance->manageUser($getID,'block',$db);
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "User blocked successfuly!")';
                    header('Location: ../view/admin/users.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to block user, Try again!")';
                    header('Location: ../view/admin/users.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/users.php');
            }
        }elseif(isset($_POST['delete']) && !empty($_POST['delete'])){
            $getID = htmlspecialchars(trim($_POST['delete']));
            if(!empty($getID)){
                $return = $instance->removeUser($getID,$db);
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "User deleted successfuly!")';
                    header('Location: ../view/admin/users.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to delete user, Try again!")';
                    header('Location: ../view/admin/users.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/users.php');
            }
        }elseif(isset($_POST['active']) && !empty($_POST['active'])){
            $getID = htmlspecialchars(trim($_POST['active']));
            if(!empty($getID)){
                $return = $instance->manageUser($getID,'active',$db);
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "User has been active successfuly!")';
                    header('Location: ../view/admin/users.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to active user, Try again!")';
                    header('Location: ../view/admin/users.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/users.php');
            }
        }elseif(isset($_POST['accept']) && !empty($_POST['accept'])){
            $getID = htmlspecialchars(trim($_POST['accept']));
            if(!empty($getID)){
                $return = $instance->manageUser($getID,'active',$db);
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "User has been accepted successfuly!")';
                    header('Location: ../view/admin/users.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to accept user, Try again!")';
                    header('Location: ../view/admin/users.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/users.php');
            }
        }elseif(isset($_POST['reject']) && !empty($_POST['reject'])){
            $getID = htmlspecialchars(trim($_POST['reject']));
            if(!empty($getID)){
                $return = $instance->manageUser($getID,'reject',$db);
                if($return === true){
                    $_SESSION['alert'] = 'showAlert("success", "User has been rejected successfuly!")';
                    header('Location: ../view/admin/users.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to reject user, Try again!")';
                    header('Location: ../view/admin/users.php');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: ../view/admin/users.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
            header('Location: ../view/admin/users.php');
        }
    }else{
        $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
        header('Location: ../view/admin/users.php');
    }








?>