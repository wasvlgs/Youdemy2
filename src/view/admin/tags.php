<?php


    session_start();
    require_once '../../classes/database.php';
    require_once '../../classes/tags.php';

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
    <title>Gérer les tags - Youdemy Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Modal backdrop */
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        /* Modal content */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            z-index: 1001;
            max-width: 400px;
            width: 100%;
        }
    </style>
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
                    <h2 class="text-xl font-bold text-indigo-600">Gérer les tags</h2>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-6 overflow-auto">
                <div class="max-w-5xl mx-auto">
                    <!-- Tag Management -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">Gérer les tags</h1>
                        <!-- Button to open modal for adding a tag -->
                        <button data-modal="addTagModal" class="flex items-center space-x-2 bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">
                            <i class="fas fa-plus-circle"></i>
                            <span>Ajouter un tag</span>
                        </button>
                    </div>

                    <!-- Tags Table -->
                    <section>
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 text-left">Tag Name</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    $getTags = tags::getTags(Database::getInstance()->getConnect());
                                    if($getTags != null && $getTags->rowCount() > 0){
                                        foreach($getTags as $tag){
                                            echo '<tr>
                                            <td class="py-3 px-6">'.$tag['name'].'</td>
                                            <td class="py-3 px-6">
                                                <button onclick="openModule('.$tag['id_tag'].',`'.$tag['name'].'`)" data-modal="editTagModal" data-tag-id="1" class="bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>
                                                <form action="../../controller/removeTagController.php" method="POST" class="inline">
                                                    <button value="'.$tag['id_tag'].'" name="removeTag" type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>';
                                        }
                                    }else{
                                        echo 'No tag exict!';
                                    }

                                ?>

                            </tbody>
                        </table>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal for Adding Tag -->
    <div class="modal-backdrop" id="modalBackdrop">
        <!-- Modal content for adding a tag -->
        <div class="modal" id="addTagModal">
            <h2 class="text-2xl font-bold mb-4">Ajouter un tag</h2>
            <form action="../../controller/ajouterTagController.php" method="POST">
                <label for="tagName" class="block text-gray-700">Nom du tag</label>
                <input id="tagName" name="tag_name" type="text" class="w-full px-4 py-2 border rounded-lg mb-4" placeholder="Nom du tag" required>
                
                <div class="flex space-x-4">
                    <button name="addTag" type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Ajouter</button>
                    <button type="button" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" onclick="closeModal()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Editing Tag -->
    <div class="modal-backdrop" id="editModalBackdrop">
        <!-- Modal content for editing a tag -->
        <div class="modal" id="editTagModal">
            <h2 class="text-2xl font-bold mb-4">Modifier le tag</h2>
            <form action="../../controller/editTagController.php" method="POST">
                <label for="editTagName" class="block text-gray-700">Nom du tag</label>
                <input id="editTagName" name="editTagName" type="text" class="w-full px-4 py-2 border rounded-lg mb-4" placeholder="Nom du tag" required>
                
                <div class="flex space-x-4">
                    <button id="editTagId" name="edit" type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Modifier</button>
                    <button type="button" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" onclick="closeEditModal()">Annuler</button>
                </div>
            </form>
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
        // Open modal for adding tag
        document.querySelectorAll('[data-modal="addTagModal"]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('addTagModal').style.display = 'block';
                document.getElementById('modalBackdrop').style.display = 'block';
            });
        });

        // Open modal for editing tag
        function openModule(id,name){
            document.getElementById('editTagModal').style.display = 'block';
            document.getElementById('editModalBackdrop').style.display = 'block';
            document.getElementById("editTagId").value = id;
            document.getElementById("editTagName").value = name;
        }

        // Close modal for adding tag
        function closeModal() {
            document.getElementById('addTagModal').style.display = 'none';
            document.getElementById('modalBackdrop').style.display = 'none';
        }

        // Close modal for editing tag
        function closeEditModal() {
            document.getElementById('editTagModal').style.display = 'none';
            document.getElementById('editModalBackdrop').style.display = 'none';
        }
    </script>
</body>
</html>
