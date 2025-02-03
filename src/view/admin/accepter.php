<?php
    session_start();

    require_once '../../classes/database.php';
    require_once '../../classes/cours.php';

    if(isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 1){
        if(isset($_POST['logout'])){
            session_destroy();
            header('Location: ../../../index.php');
            die();
        }
    } else {
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
    <title>Accepter les Cours - Youdemy Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Enhanced Sidebar -->
        <?php include_once 'aside.php'; ?>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-[100vh] overflow-y-auto">
            <!-- Enhanced Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <a href="../../../index.php" class="text-gray-600 hover:text-gray-900">Home</a>
                        <a href="../catalogue.php" class="text-gray-600 hover:text-gray-900">Catalogue</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <h2 class="text-xl font-bold text-indigo-600">Course Approval</h2>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-auto">
                <div class="max-w-5xl mx-auto">

                    <!-- Courses List -->
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800">Pending Courses</h2>
                        </div>
                        <div class="p-6">
                            <div id="courses-list" class="space-y-4">
                                <?php

                                    $getCourses = cours::getAllPendingCourses(Database::getInstance()->getConnect());
                                    if($getCourses != null && $getCourses->rowCount() > 0){
                                        foreach($getCourses as $cours){
                                            echo '<div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex justify-between items-center">
                                        <div class="space-y-1">
                                            <h3 class="font-medium text-gray-900">'.$cours['titre'].'</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span class="flex items-center">
                                                    <i class="fas fa-folder mr-2"></i>
                                                    '.$cours['name'].'
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-user mr-2"></i>
                                                    '.$cours['prenom'].' '.$cours['nom'].'
                                                </span>
                                            </div>
                                        </div>
                                        <form action="../../controller/acceptCoursController.php" method="POST" class="flex items-center space-x-2">
                                            <button value="'.$cours['id_cours'].'" name="accept" class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                                                <i class="fas fa-check mr-2"></i> Accept
                                            </button>
                                            <button value="'.$cours['id_cours'].'" name="reject" class="flex items-center space-x-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                                                <i class="fas fa-times mr-2"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>';
                                        }
                                    }else{
                                        echo 'No course exict!';
                                    }

                                ?>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Alert Container (Initially hidden) -->
    <div id="alert-container" class="fixed top-0 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-lg p-4 mb-4 hidden rounded-lg">
        <!-- Success Alert -->
        <div id="success-alert" class="alert hidden p-4 mb-4 text-green-700 bg-green-100 rounded-lg shadow-md w-full">
            <span id="success-message" class="font-medium">Success! Your action was completed.</span>
        </div>

        <!-- Error Alert -->
        <div id="error-alert" class="alert hidden p-4 mb-4 text-red-700 bg-red-100 rounded-lg shadow-md w-full">
            <span id="error-message" class="font-medium">Error! Something went wrong.</span>
        </div>
    </div>
    <script>
<?php

        if(isset($_SESSION['alert'])){
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
        ?>
        // Function to display the alert (success or error)
        function showAlert(type, message) {
        const alertContainer = document.getElementById('alert-container');
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        // Set the alert message
        if (type === 'success') {
            successMessage.textContent = message;
            successAlert.classList.remove('hidden');
            errorAlert.classList.add('hidden');
        } else if (type === 'error') {
            errorMessage.textContent = message;
            errorAlert.classList.remove('hidden');
            successAlert.classList.add('hidden');
        }

        // Show the alert container
        alertContainer.classList.remove('hidden');

        // Automatically close the alert after 3 seconds
        setTimeout(closeAlert, 2000);
        }

        // Function to close the alert
        function closeAlert() {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.classList.add('hidden');
        }

    </script>
</body>
</html>
