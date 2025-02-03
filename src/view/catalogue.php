<?php


session_start();
require_once '../classes/database.php';


$getButtons = '';
$getSelect = '';

if(isset($_SESSION['id']) && isset($_SESSION['role']) && !empty($_SESSION['id']) && !empty($_SESSION['role'])){
    if($_SESSION['role'] == 1){
        $getButtons = '<a href="admin/dashboard.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Dashboard</a>';
    }elseif($_SESSION['role'] == 2){
        $getButtons = '<a href="teacher/dashboard.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Dashboard</a>';
    }else{
        $getButtons = '<form method="post" class="flex items-center space-x-4">
                    <button name="logout" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Logout</button>
                </form>';
        $getSelect = '<a href="student/mescours.php" class="text-gray-600 hover:text-indigo-600 transition-colors">My Courses</a>';
    }
}else{
    $getButtons = '<a href="login/login.php" class="px-4 py-2 text-gray-600 hover:text-indigo-600 transition-colors">Log In</a>
<a href="login/login.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Sign Up Free</a>';
}

if(isset($_POST['logout'])){
    session_destroy();
    header('Location: ../../index.php');
    die();
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Catalogue - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body class="bg-gray-50 font-sans">

    <!-- Top Header -->
    <header class="min-h-[80px] w-full bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center px-5">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg"></div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Youdemy</span>
                </a>
                
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="../../index.php" class="text-gray-600 hover:text-indigo-600 transition-colors">Home</a>
                    <?php
                        if($getSelect){
                            echo $getSelect;
                        }
                     ?>
                    <a href="../../index.php#about" class="text-gray-600 hover:text-indigo-600 transition-colors">About</a>
                    <a href="../../index.php#contact" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                <?php

                    if($getButtons){
                        echo $getButtons;
                    }


                ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Category Header -->
    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto px-6 md:px-12 flex justify-between items-center space-x-6">
            <!-- Category Buttons -->
            <div class="flex overflow-x-auto space-x-4 py-2 px-4 sm:px-6 custom-scrollbar">
                <a href="catalogue.php" class="px-6 py-2 bg-indigo-100 rounded-lg text-indigo-700 shadow-md hover:bg-indigo-200 transition duration-300 flex-shrink-0">
                    All
                </a>

                <?php

                    require_once '../classes/categorie.php';
                    $getCategories = categorie::getCategories(Database::getInstance()->getConnect());

                    if($getCategories != null && $getCategories->rowCount() > 0){
                        foreach($getCategories as $categorie){
                            echo '<a href="catalogue.php?catalogue='.$categorie['id_categorie'].'&page=1" class="px-6 py-2 bg-gray-100 rounded-lg text-gray-700 shadow-md hover:bg-gray-200 transition duration-300 flex-shrink-0">
                                '.$categorie['name'].'
                            </a>';
                        }
                    }


                ?>
            </div>

            
            <!-- Search Bar -->
            <form method="get" class="flex items-center space-x-4">
                <input <?php if(isset($_GET['search']) && !empty($_GET['searchValue'])){
                    echo 'value="'.htmlspecialchars(trim($_GET['searchValue'])).'"';
                } ?> name="searchValue" type="text" placeholder="Search courses..." class="px-4  py-2 w-64 ring-[1px] rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <button value="search" name="search" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition duration-200">Search</button>
            </form>
        </div>
    </header>


    <!-- Courses Catalogue -->
    <main class="container mx-auto px-6 md:px-12 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Courses Catalogue</h1>

        <!-- Course Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">


            <?php

                $getOffSet = '';
                $getIdCategorie = '';
                $getSearchValue = '';
                require_once '../classes/cours.php';
                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $getPage = htmlspecialchars(trim($_GET['page']));
                    if(!empty($getPage)){
                        $getOffSet = ($getPage-1)*6;
                    }
                }
                if(isset($_GET['catalogue']) && !empty($_GET['catalogue'])){
                    $getIdCategorie = htmlspecialchars(trim($_GET['catalogue']));
                }
                if(isset($_GET['search']) && !empty($_GET['searchValue'])){
                    $getSearchValue = htmlspecialchars(trim($_GET['searchValue']));
                }
                $getCours = cours::getCours(Database::getInstance()->getConnect(),$getOffSet,$getIdCategorie,$getSearchValue);
                if($getCours != null && $getCours['data']->rowCount() > 0){
                    $getPages = $getCours['pages'];
                    foreach ($getCours['data'] as $cours) {
                        $getDesc = substr($cours['description'],0,100);
                        echo '<div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl max-w-sm">
                    <!-- Image Section -->
                    <div class="relative">
                        <img 
                            src="../../public/img/coursImage/'.$cours['imgSrc'].'" 
                            alt="Course Image" 
                            class="w-full h-52 object-cover"
                        />
                        <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-sm font-medium text-indigo-600">
                            '.$cours['name'].'
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6">
                        <!-- Author and Date -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>'.$cours['prenom'].' '.$cours['nom'].'</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>'.$cours['date_create'].'</span>
                            </div>
                        </div>

                        <!-- Course Title and Description -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">
                            '.$cours['titre'].'
                        </h3>
                        
                        <p class="text-gray-600 mb-4">
                            '.$getDesc.'...
                        </p>



                        <!-- Action Button and Rating -->
                        <div class="flex justify-between items-center">
                            <a 
                                href="cour.php?cours='.$cours['id_cours'].'"
                                target="_blank" 
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200"
                            >
                                View Details
                            </a>
                            <div class="flex items-center space-x-1">
                                <span class="text-yellow-400">★★★★</span>
                                <span class="text-gray-400">★</span>
                                <span class="text-sm text-gray-600 ml-1">(4.0)</span>
                            </div>
                        </div>
                    </div>
                </div>';
                    }
                }else{
                    echo 'No cours exict';
                }

            ?>

            <!-- 

            <div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl">
                <img src="/images/course2.jpg" alt="Course Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Web Development Bootcamp</h3>
                    <p class="mt-3 text-gray-600">Master HTML, CSS, JavaScript, and React in this bootcamp.</p>
                    <button class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition duration-200">View Details</button>
                </div>
            </div> -->

            <!-- Repeat above card block for additional courses -->
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center space-x-4">
            <?php

                if(isset($getPages) && $getPages == 1){
                    echo '<a href="catalogue.php?page=1" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition duration-200">1</a>';
                }elseif(isset($getPages) && $getPages > 1){

                    for($i = 1; $i <= $getPages; $i++){
                        echo '<a href="catalogue.php?page='.$i.'" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition duration-200">'.$i.'</a>';
                    }

                }


            ?>
            <!-- <a href="#" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-md hover:bg-gray-200 focus:outline-none transition duration-200">Previous</a>
            <a href="#" class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none transition duration-200">1</a>
            <a href="#" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-md hover:bg-gray-200 focus:outline-none transition duration-200">2</a>
            <a href="#" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-md hover:bg-gray-200 focus:outline-none transition duration-200">3</a>
            <a href="#" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg shadow-md hover:bg-gray-200 focus:outline-none transition duration-200">Next</a> -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-6 md:px-12 text-center">
            <p class="text-sm">&copy; 2025 Youdemy. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
