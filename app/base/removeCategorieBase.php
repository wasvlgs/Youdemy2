<?php



    session_start();
    require_once '../classes/database.php';
    require_once '../classes/categorie.php';
    $instance = new categorie();

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['remove']) && !empty($_POST['remove']) && isset($_SESSION['id'])){

        $getCategorie = htmlspecialchars(trim($_POST['remove']));
        if(!empty($getCategorie)){
            $return = $instance->removeCategorie($getCategorie,Database::getInstance()->getConnect());
            if($return === true){
                $_SESSION['alert'] = 'showAlert("success", "Categorie removed successfuly!")';
                header('Location: ../view/admin/dashboard.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to remove categorie!")';
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
