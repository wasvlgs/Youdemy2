<?php

    session_start();
    require_once '../classes/database.php';
    require_once '../classes/categorie.php';
    $instance = new categorie();


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addCategorie']) && isset($_SESSION['id'])){
        $categorie = htmlspecialchars(trim($_POST['setCategorie']));
        if(!empty($categorie)){
            $return = $instance->addCategorie(null,$categorie,Database::getInstance()->getConnect());
            if($return === true){
                $_SESSION['alert'] = 'showAlert("success", "Category added successfuly!")';
                header('Location: ../view/admin/dashboard.php');
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Faild to add category!")';
                header('Location: ../view/admin/dashboard.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
            header('Location: ../view/admin/dashboard.php');
        }
    }




?>