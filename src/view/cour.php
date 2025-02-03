
<?php

    session_start();
    require_once '../classes/database.php';
    require_once '../classes/cours.php';
    require_once '../classes/cours.php';
    $cour = '';
    $instance = new cours();

    $getButton = '';


    if(isset($_SESSION['id']) && isset($_SESSION['role']) && !empty($_SESSION['id']) && !empty($_SESSION['role'])){

        if(isset($_GET['cours']) && !empty($_GET['cours'])){

            $getCourId = htmlspecialchars(trim($_GET['cours']));


                if($_SESSION['role'] == 3 && !empty($getCourId)){
                if(isset($_POST['join'])){
                    $instance->joinCour($_SESSION['id'],$getCourId,Database::getInstance()->getConnect());
                }
                $getCount = $instance->checkMyCour($_SESSION['id'],$getCourId,Database::getInstance()->getConnect());
                if($getCount == 1 && !empty($getCourId)){
                    $getButton = '<a href="student/mescours.php" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105 hover:shadow-lg">
                    Joined
                </a>';
                }else{
                    $getButton = '<form method="POST"><button name="join" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full font-medium transition-all transform hover:scale-105 hover:shadow-lg">
                    Join the Course
                </button></form>';
                }
            }
            
            $cour = $instance->getSingleCour($getCourId,Database::getInstance()->getConnect());
            if($cour == null){
                die('No cour exict');
            }
        }else{
            die('No cour exict');
        }
    }else{
        session_destroy();
        header('Location: login/login.php');
        die('No cour exict');
    }

    

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-indigo-600 via-purple-500 to-purple-600 text-white py-6 shadow-lg">
        <div class="container mx-auto px-6 md:px-12 flex justify-between items-center">
            <a href="catalogue.php" class="text-lg font-bold hover:text-gray-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back to Catalogue
            </a>
            <nav class="space-x-4">
                
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 md:px-12 py-12">
        <!-- Course Details -->
        <section class="mb-12 bg-white rounded-2xl shadow-xl p-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold text-gray-800 mb-6 leading-tight"><?php
                    if(isset($cour) && !empty($cour)){
                        echo $cour['titre'];
                    }
                 ?></h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed"><?php
                    if(isset($cour) && !empty($cour)){
                        echo $cour['description'];
                    }
                 ?></p>
                
                <div class="flex flex-wrap items-center gap-6 mb-8">
                    <div class="flex items-center gap-2">
                        <div>
                            <p class="text-gray-800 font-medium">Created by:</p>
                            <p class="text-indigo-600 font-semibold"><?php
                    if(isset($cour) && !empty($cour)){
                        echo $cour['prenom'] . ' ' . $cour['nom'];
                    }
                 ?></p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <?php

                            require_once '../classes/tags.php';
                            $instanceTags = new tags();
                            $getTags = $instanceTags->tags($getCourId,Database::getInstance()->getConnect());

                            if($getTags != null && $getTags->rowCount() > 0){
                                $colors = ['indigo','purple','blue'];
                                $count = 0;

                                foreach($getTags as $tag){
                                    echo '<span class="bg-'.$colors[$count].'-100 text-'.$colors[$count].'-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-indigo-200 transition-colors">#'.$tag['name'].'</span>';
                                    if($count < count($colors)){
                                        $count++;
                                    }else{
                                        $count = 0;
                                    }
                                }
                            }


                        ?>
                        <!-- <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-indigo-200 transition-colors">#Programming</span>
                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-purple-200 transition-colors">#Beginner</span>
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-200 transition-colors">#Coding</span> -->
                    </div>
                </div>

                <?php echo $getButton; ?>
            </div>
        </section>
            <?php
                if(isset($cour) && !empty($cour)){
                    if($cour['typeContent'] === "text"){

                        echo '<section class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Text Content</h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-600 leading-relaxed mb-6">
                                '.$cour['content'].'
                            </p>
                            
                        </div>
                    </section>';

                    }elseif($cour['typeContent'] === "video"){
                        echo '<section class="bg-white rounded-2xl shadow-xl p-8 mb-8 overflow-hidden">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Video Content</h2>
                        <div class="aspect-video bg-gray-900 rounded-xl overflow-hidden relative group">
                            <video controls class="w-full h-full object-cover">
                                <source src="../../public/videos/'.$cour['content'].'" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/30 transition-all cursor-pointer">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all">
                                    <i class="fas fa-play text-indigo-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </section>';
                    }
                }
            ?>

        <!-- <section class="bg-white rounded-2xl shadow-xl p-8 mb-8 overflow-hidden">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Video Content</h2>
            <div class="aspect-video bg-gray-900 rounded-xl overflow-hidden relative group">
                <video controls class="w-full h-full object-cover">
                    <source src="/videos/sample-course.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-black/30 transition-all cursor-pointer">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all">
                        <i class="fas fa-play text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </section> -->


        <!-- <section class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Text Content</h2>
            <div class="prose max-w-none">
                <p class="text-gray-600 leading-relaxed mb-6">
                    Welcome to the introduction to programming course. This course is designed to provide you with the fundamental knowledge required to understand the basics of coding. You will learn about variables, data types, control structures, and much more.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    By the end of this course, you should be able to write simple programs and understand how programming can solve real-world problems. Dive in and start learning today!
                </p>
            </div>
        </section> -->
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 md:px-12 text-center">
            <p class="text-gray-300">&copy; 2025 Youdemy. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Add interactive video play functionality
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('video');
            const overlay = video.parentElement.querySelector('.absolute');
            
            overlay.addEventListener('click', function() {
                video.play();
                overlay.style.display = 'none';
            });

            video.addEventListener('pause', function() {
                overlay.style.display = 'flex';
            });
        });
    </script>
</body>
</html>