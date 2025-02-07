<?php


            session_start();

            require_once '../app/models/database.php';
            require_once '../app/models/video.php';
            require_once '../app/models/text.php';
            require_once '../app/models/tags.php';



    class coursCont{

        public function acceptCoursAction(){
            $instance = new cours();
        
        
        
            if($_SERVER['REQUEST_METHOD'] === "POST"){
        
                if(isset($_POST['accept']) && !empty($_POST['accept'])){
                    $coursId = htmlspecialchars(trim($_POST['accept']));
                    if(!empty($coursId)){
                        $return = $instance->accepteCourse($coursId,Database::getInstance()->getConnect());
                        if($return === true){
                            $_SESSION['alert'] = 'showAlert("success", "Course approved succefuly!")';
                            header('Location: http://localhost/youdemy2/public/admin/accepter');
                        }else{
                            $_SESSION['alert'] = 'showAlert("error", "Faild to approve, try again!")';
                            header('Location: http://localhost/youdemy2/public/admin/accepter');
                        }
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                        header('Location: http://localhost/youdemy2/public/admin/accepter');
                    }
                }elseif(isset($_POST['reject']) && !empty($_POST['reject'])){
                    $coursId = htmlspecialchars(trim($_POST['reject']));
                    if(!empty($coursId)){
                        $return = $instance->rejectCourse($coursId,Database::getInstance()->getConnect());
                        if($return === true){
                            $_SESSION['alert'] = 'showAlert("success", "Course rejected succefuly!")';
                            header('Location: http://localhost/youdemy2/public/admin/accepter');
                        }else{
                            $_SESSION['alert'] = 'showAlert("error", "Faild to reject, try again!")';
                            header('Location: http://localhost/youdemy2/public/admin/accepter');
                        }
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                        header('Location: http://localhost/youdemy2/public/admin/accepter');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!!")';
                    header('Location: http://localhost/youdemy2/public/admin/accepter');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/admin/accepter');
            }
        
        }

        public function addCourAction(){
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
        
                if(!empty($getTitre) && !empty($getDesc) && !empty($getType) && move_uploaded_file($getImg['tmp_name'], 'img/coursImage/' . $getImg['name'])){
        
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
                            header('Location: http://localhost/youdemy2/public/teacher/cours');
                        }else{
                            $_SESSION['alert'] = 'showAlert("error", "Faild to add course!")';
                            header('Location: http://localhost/youdemy2/public/teacher/cours');
                        }
                        
                        
                    }elseif($getType === "video" && !empty($getVideo)){
                        if(move_uploaded_file($getVideo['tmp_name'], 'videos/'.$getVideo['name'])){
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
                                header('Location: http://localhost/youdemy2/public/teacher/cours');
                            }else{
                                $_SESSION['alert'] = 'showAlert("error", "Faild to add course!")';
                                header('Location: http://localhost/youdemy2/public/teacher/cours');
                            }
                        }
                        
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Invalid information, try again later!")';
                        header('Location: http://localhost/youdemy2/public/teacher/cours');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information, try again!")';
                    header('Location: http://localhost/youdemy2/public/teacher/cours');
                }
            }
        }

        public function editCourAction(){
            $callCourse = new cours();
        
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit_course']) && !empty($_POST['edit_course']) && isset($_SESSION['id'])){
        
                $getCourseId = htmlspecialchars(trim($_POST['edit_course']));
                $getTitre = htmlspecialchars(trim($_POST['edit_title']));
                $getDesc = htmlspecialchars(trim($_POST['edit_description']));
                if(!empty($getCourseId) && !empty($getTitre) && !empty($getDesc)){
                    $getReturn = $callCourse->editCour($getTitre,$getDesc,$getCourseId,$_SESSION['id'],Database::getInstance()->getConnect());
                    if($getReturn === true){
                        $_SESSION['alert'] = 'showAlert("success", "Course edited succefuly!")';
                        header('Location: http://localhost/youdemy2/public/teacher/cours');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to edit the course!")';
                        header('Location: http://localhost/youdemy2/public/teacher/cours');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/teacher/cours');
                }
                
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/teacher/cours');
            }
        }

        public function removeCoursAction(){
            $callCourse = new cours();
        
            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['remove']) && !empty($_POST['remove']) && isset($_SESSION['id'])){
        
                $coursId = htmlspecialchars(trim($_POST['remove']));
                if(!empty($coursId)){
        
                    $getReturn = $callCourse->removeCour($coursId,$_SESSION['id'],Database::getInstance()->getConnect());
                    if($getReturn === true){
                        $_SESSION['alert'] = 'showAlert("success", "Course removed successfuly!")';
                        header('Location: http://localhost/youdemy2/public/teacher/cours');
                    }else{
                        $_SESSION['alert'] = 'showAlert("error", "Faild to remove course, Try again!")';
                        header('Location: http://localhost/youdemy2/public/teacher/cours');
                    }
                }else{
                    $_SESSION['alert'] = 'showAlert("error", "Invalid information!")';
                    header('Location: http://localhost/youdemy2/public/teacher/cours');
                }
            }else{
                $_SESSION['alert'] = 'showAlert("error", "Error try again!")';
                header('Location: http://localhost/youdemy2/public/teacher/cours');
            }
        
        }
    }