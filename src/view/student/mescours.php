
<?php


    session_start();
    require_once '../../classes/database.php';


    if(isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 3){
        $getID = $_SESSION['id'];
    }else{
        session_destroy();
        header('Location: ../login/login.php');
        die();
    }


    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: ../../../index.php');
        die();
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="../../../index.php" class="text-gray-600 hover:text-indigo-600 transition-colors">Home</a>
                    <a href="../catalogue.php" class="text-gray-600 hover:text-indigo-600 transition-colors">All Courses</a>
                    <a href="../../../index.php#about" class="text-gray-600 hover:text-indigo-600 transition-colors">About</a>
                    <a href="../../../index.php#contact" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact</a>
                </nav>

                <form method="post" class="flex items-center space-x-4">
                    <button name="logout" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 md:px-12 py-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">My Courses</h1>

        <!-- Course Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">

        <?php

            require_once '../../classes/cours.php';
            $instanceCours = new cours();
            $getCours = $instanceCours->mycours($getID,Database::getInstance()->getConnect());

            if($getCours != null && $getCours->rowCount() > 0){
                foreach($getCours as $cours){
                    $desc = substr($cours['description'], 0, 100);
                    echo '<div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl max-w-sm">
                <div class="relative">
                    <img 
                        src="../../../public/img/coursImage/'.$cours['imgSrc'].'" 
                        alt="Course Image" 
                        class="w-full h-52 object-cover"
                    />
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-sm font-medium text-indigo-600">
                        '.$cours['name'].'
                    </div>
                </div>

                <div class="p-6">
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

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        '.$cours['titre'].'
                    </h3>
                    
                    <p class="text-gray-600 mb-4">
                        '.$desc.'...
                    </p>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a target="_blank" href="../cour.php?cours='.$cours['id_cours'].'" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                Read
                            </a>
                        </div>
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
                echo 'No cours exict!';
            }


        ?>

            <!-- <div class="bg-white shadow-xl rounded-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl max-w-sm">
                <div class="relative">
                    <img 
                        src="/images/course2.jpg" 
                        alt="Course Image" 
                        class="w-full h-52 object-cover"
                    />
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-sm font-medium text-indigo-600">
                        Machine Learning
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Jane Smith</span>
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Jan 20, 2024</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Machine Learning Basics
                    </h3>
                    
                    <p class="text-gray-600 mb-4">
                        Discover the fundamentals of machine learning and AI. Learn about algorithms and data analysis...
                    </p>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                Read
                            </a>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="text-yellow-400">★★★★</span>
                            <span class="text-gray-400">★</span>
                            <span class="text-sm text-gray-600 ml-1">(4.0)</span>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Add more course cards as needed -->
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