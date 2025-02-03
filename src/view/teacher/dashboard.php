<?php


    session_start();

    require_once '../../classes/database.php';
    require_once '../../classes/cours.php';

    if(isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 2){

        $instanceCours = new cours();
        $getCount = $instanceCours->myCoursCount($_SESSION['id'],Database::getInstance()->getConnect());
        $getMyStudents = $instanceCours->myStudentCount($_SESSION['id'],Database::getInstance()->getConnect());
        $getCour = $instanceCours->getBestCours($_SESSION['id'],Database::getInstance()->getConnect());
        $getRecentActivites = $instanceCours->recentActivities($_SESSION['id'],Database::getInstance()->getConnect());


        if(isset($_POST['logout'])){
            session_destroy();
            header('Location: ../../../index.php');
            die();
        }
    }else{
        session_destroy();
        header('Location: ../login/login.php');
        die();
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Overview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Page Wrapper -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once 'aside.php'; ?>

        <!-- Main Content -->
        <div class="flex-grow flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md px-8 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <a href="../../../index.php" class="text-gray-700 text-lg font-medium hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                    <a href="../catalogue.php" class="text-gray-700 text-lg font-medium hover:text-indigo-600 transition-colors flex items-center gap-2">
                        <i class="fas fa-th-large"></i>
                        Catalogue
                    </a>
                </div>
                <h2 class="text-xl font-bold text-indigo-600 flex items-center gap-2">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                </h2>
            </header>

            <!-- Content Area -->
            <main class="flex-grow p-8 overflow-auto">
                <div class="max-w-6xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Overview</h1>

                    <!-- Statistics Section -->
                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Total Courses -->
                        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-book text-2xl text-indigo-600"></i>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-800"><?php 
                                    if($getCount > 0){
                                        echo $getCount;
                                    }else{
                                        echo 0;
                                    }
                                 ?></h2>
                            </div>
                            <p class="text-gray-600 font-medium">Total Courses</p>
                        </div>

                        <!-- Total Students -->
                        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-2xl text-purple-600"></i>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-800">
                                    <?php 
                                        if($getMyStudents > 0){
                                            echo $getMyStudents;
                                        }else{
                                            echo 0;
                                        }
                                    ?>
                                </h2>
                            </div>
                            <p class="text-gray-600 font-medium">Total Students</p>
                        </div>

                        <!-- Active Enrollments -->
                        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-2xl text-yellow-600"></i>
                                </div>
                            </div>
                            <p class="text-gray-600 font-medium mb-2">Best Course</p>
                            <div class="bg-yellow-50 rounded-lg p-2 mt-1">
                                <h3 class="text-sm font-semibold text-gray-800 truncate">
                                    <?php

                                        if($getCour != null){
                                            echo $getCour['titre'];
                                        }else{
                                            echo 'No cour exict';
                                        }
                                    ?>
                                </h3>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <i class="fas fa-user-graduate mr-1"></i>
                                    <span><?php

                                        if($getCour != null){
                                            echo $getCour['joinCount'];
                                        }else{
                                            echo 0;
                                        }
                                        ?> students enrolled</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Recent Activity Section -->
                    <section class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-history text-indigo-600"></i>
                            Recent Activity
                        </h2>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user text-indigo-600"></i>
                                                    Student Name
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-book text-indigo-600"></i>
                                                    Course
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-calendar text-indigo-600"></i>
                                                    Enrollment Date
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">

                                        <?php

                                            if($getRecentActivites != null && $getRecentActivites->rowCount() > 0){
                                                $colors = ['blue','purple','green'];
                                                $count = 0;
                                                foreach($getRecentActivites as $activitie){
                                                    echo '<tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    '.$activitie['prenom'].' '.$activitie['nom'].'
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="bg-'.$colors[$count].'-100 text-'.$colors[$count].'-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    '.$activitie['titre'].'
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-500">'.$activitie['date_join'].'</td>
                                        </tr>';
                                                    if($count < count($colors) -1){
                                                        $count++;
                                                    }else{
                                                        $count = 0;
                                                    }
                                                }
                                            }else{
                                                echo 'No activity exict';
                                            }
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</body>
</html>