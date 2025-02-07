<?php


    session_start();
            require_once '../app/models/database.php';
            require_once '../app/models/categorie.php';



    class categorieCont{

        public function addCategorieAction(){

            $instance = new categorie();



            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addCategorie']) && isset($_SESSION['id'])){
                $categorie = htmlspecialchars(trim($_POST['setCategorie']));
                if(!empty($categorie)){
                    $return = $instance->addCategorie($categorie,Database::getInstance()->getConnect());
                    if($return === true){
                        $_SESSION['alert'] = 'showAlert("success", "Category added successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to add category!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/dashboard');
                }
            }
        }

        public function editCategorieAction(){
            $instance = new categorie();
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['saveChange']) && !empty($_POST['saveChange']) && isset($_SESSION['id'])){
        
                $getCategorie = htmlspecialchars(trim($_POST['saveChange']));
                $getName = htmlspecialchars(trim($_POST['editName']));
                if(!empty($getCategorie) && !empty($getName)){
                    $return = $instance->editCategorie($getCategorie,$getName,Database::getInstance()->getConnect());
                    if($return === true){
                        $_SESSION['alert'] = 'showAlert("success", "Categorie edited successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to edit categorie!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/dashboard');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: http://localhost/youdemy2/public/admin/dashboard');
            }
        }

        public function removeCategorieAction(){
            $instance = new categorie();
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['remove']) && !empty($_POST['remove']) && isset($_SESSION['id'])){
        
                $getCategorie = htmlspecialchars(trim($_POST['remove']));
                if(!empty($getCategorie)){
                    $return = $instance->removeCategorie($getCategorie,Database::getInstance()->getConnect());
                    if($return === true){
                        $_SESSION['alert'] = 'showAlert("success", "Categorie removed successfuly!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to remove categorie!")';
                        header('Location: http://localhost/youdemy2/public/admin/dashboard');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/admin/dashboard');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                header('Location: http://localhost/youdemy2/public/admin/dashboard');
            }
        }
    }