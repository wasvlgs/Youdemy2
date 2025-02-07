<?php


    session_start();

    require_once '../classes/database.php';
    require_once '../classes/video.php';
    require_once '../classes/text.php';
    require_once '../classes/tags.php';
    $db = Database::getInstance()->getConnect();

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_course'])){

        $getImg = $_FILES['image_content'];
        $getTitre = htmlspecialchars(trim($_POST['title']));
        $getDesc = htmlspecialchars(trim($_POST['description']));
        $getType = htmlspecialchars(trim($_POST['content_type']));
        $getText = htmlspecialchars(trim($_POST['text_content']));
        $getCategorie = htmlspecialchars(trim($_POST['categorie']));
        $getVideo = $_FILES['video_content'];
        $getTags = $_POST['selected_tags'];
        $arrTags = explode(",", $getTags);

        if(!empty($getTitre) && !empty($getDesc) && !empty($getType) && move_uploaded_file($getImg['tmp_name'], '../../public/img/coursImage/' . $getImg['name'])){

            if($getType === "text" && !empty($getText)){
                $textInstance = new textContent(null,$getTitre,$getDesc,$getImg['name'], $_SESSION['id'],$getCategorie,$getText);
                $getIDCour = $textInstance->addTextCour();
                if($getIDCour != false){
                    foreach($arrTags as $tag){
                        $getInstance = new tags(null,$tag);
                        $addTags = $getInstance->addTags($db);
                        if($addTags != false){
                            $getInstance->addAssocTags($addTags,$getIDCour,$db);
                        }
                    }
                    $_SESSION['alert'] = 'showAlert("success", "Course added with success!")';
                    header('Location: ../view/teacher/cours.php');
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Faild to add course!")';
                    header('Location: ../view/teacher/cours.php');
                }
                
                
            }elseif($getType === "video" && !empty($getVideo)){
                if(move_uploaded_file($getVideo['tmp_name'], '../../public/videos/'.$getVideo['name'])){
                    $textInstance = new videoContent(null,$getTitre,$getDesc,$getImg['name'], $_SESSION['id'],$getCategorie,$getVideo['name']);
                    $getIDCour = $textInstance->addVideoCour();
                    if($getIDCour != false){
                        foreach($arrTags as $tag){
                            $getInstance = new tags(null,$tag);
                            $addTags = $getInstance->addTags($db);
                            if($addTags != false){
                                $getInstance->addAssocTags($addTags,$getIDCour,$db);
                            }
                        }
                        $_SESSION['alert'] = 'showAlert("success", "Course added with success!")';
                        header('Location: ../view/teacher/cours.php');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to add course!")';
                        header('Location: ../view/teacher/cours.php');
                    }
                }
                
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Invalid information, try again!")';
                header('Location: ../view/teacher/cours.php');
            }
        }else{
            $_SESSION['alert'] = 'showAlert("error", "Invalid information, try again!")';
            header('Location: ../view/teacher/cours.php');
        }
    }




?>