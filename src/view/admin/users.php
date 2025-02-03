<?php

    
    require_once '../../classes/database.php';
    require_once '../../classes/user.php';

    if(isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 1){

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
    <title>Gérer les utilisateurs - Youdemy Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include_once 'aside.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-[100vh] overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <a href="../../../index.php" class="text-gray-600 hover:text-gray-900">Home</a>
                        <a href="../catalogue.php" class="text-gray-600 hover:text-gray-900">Catalogue</a>
                    </div>
                    <h2 class="text-xl font-bold text-indigo-600">Gérer les utilisateurs</h2>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6 overflow-auto">
                <div class="max-w-5xl mx-auto">
                    <!-- User Management -->
                    <section class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">Gérer les utilisateurs</h1>
                        <div class="flex space-x-4">
                            <a href="users.php" class="flex items-center space-x-2 bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">
                                <i class="fas fa-users"></i>
                                <span>Tous</span>
                            </a>
                            <a href="users.php?users=teachers" class="flex items-center space-x-2 bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Enseignants</span>
                            </a>
                            <a href="users.php?users=students" class="flex items-center space-x-2 bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">
                                <i class="fas fa-user-graduate"></i>
                                <span>Étudiants</span>
                            </a>
                        </div>
                    </section>

                    <!-- User Cards -->
                    <section>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php 
                                $filter = '';
                                if(isset($_GET['users']) && ($_GET['users'] === "teachers" || $_GET['users'] === "students")){
                                    $filter = $_GET['users'];
                                }
                            
                                $getUsers = user::getUsers(Database::getInstance()->getConnect(),$filter);
                                if($getUsers != null && $getUsers->rowCount() > 0){
                                    foreach($getUsers as $user){
                                        $buttons = '';
                                        if($user['name'] === "student"){
                                            if($user['statut'] === "active"){
                                                $buttons = '
                                                        <button value="'.$user['id_user'].'" name="block" class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">
                                                            <i class="fas fa-ban"></i> Bloquer
                                                        </button><button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>';
                                            }elseif($user['statut'] === "block"){
                                                $buttons = '<button value="'.$user['id_user'].'" name="active" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                                                        <i class="fas fa-check"></i> Active
                                                    </button><button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>';
                                            }else{
                                                $buttons = '<button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>';
                                            }
                                        }elseif($user['name'] === "teacher"){
                                            if($user['statut'] === "active"){
                                                $buttons = '
                                                        <button value="'.$user['id_user'].'" name="block" class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">
                                                            <i class="fas fa-ban"></i> Bloquer
                                                        </button><button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>';
                                            }elseif($user['statut'] === "pending"){
                                                $buttons = '
                                                        <button value="'.$user['id_user'].'" name="accept" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                                                        <i class="fas fa-check"></i> Accepter
                                                    </button>
                                                    <button value="'.$user['id_user'].'" name="reject" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                        <i class="fas fa-times"></i> Rejeter
                                                    </button>';
                                            }elseif($user['statut'] === "block"){
                                                $buttons = '<button value="'.$user['id_user'].'" name="active" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                                                <i class="fas fa-check"></i> Active
                                            </button><button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                    <i class="fas fa-times"></i> Delete
                                                </button>';
                                            }else{
                                                $buttons = '<button value="'.$user['id_user'].'" name="delete" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                            <i class="fas fa-times"></i> Delete
                                                        </button>';
                                            }
                                        }
                                        echo '<div class="bg-white shadow rounded-lg p-6 flex items-center justify-between">
                                        <div>
                                            <h3 class="font-bold text-gray-800">'.$user['prenom'].' '.$user['nom'].'</h3>
                                            <p class="text-gray-600">'.$user['name'].'</p>
                                        </div>
                                        <form action="../../controller/manageUsersController.php" method="POST" class="space-x-2">
                                            '.$buttons.'
                                        </form>
                                    </div>';
                                    }
                                }else{
                                    echo 'No users exict';
                                }
                            ?>

                        </div>
                    </section>
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
