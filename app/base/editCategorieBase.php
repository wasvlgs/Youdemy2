<?php



    session_start();
    require_once '../classes/database.php';
    require_once '../classes/categorie.php';
    $instance = new categorie();

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['saveChange']) && !empty($_POST['saveChange']) && isset($_SESSION['id'])){

        $getCategorie = htmlspecialchars(trim($_POST['saveChange']));
        $getName = htmlspecialchars(trim($_POST['editName']));
        if(!empty($getCategorie) && !empty($getName)){
            $return = $instance->editCategorie($getCategorie,$getName,Database::getInstance()->getConnect());
            if($return === true){
                $_SESSION['alert'] = 'showAlert("success", "Categorie edited successfuly!")';
                header('Location: ../view/admin/dashboard.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to edit categorie!")';
                header('Location: ../view/admin/dashboard.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
            header('Location: ../view/admin/dashboard.php');
        }
    }else{
        $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
        header('Location: ../view/admin/dashboard.php');
    }



?>
