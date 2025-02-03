<?php
    session_start();
    require_once '../../classes/database.php';
    require_once '../../classes/categorie.php';
    require_once '../../classes/cours.php';
    require_once '../../classes/tags.php';

    $getID = '';
    $instanceCours = new cours();
        if(isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 2){
        $getID = $_SESSION['id'];
        $getCount = $instanceCours->myCoursCount($getID,Database::getInstance()->getConnect());
        $getMyStudents = $instanceCours->myStudentCount($getID,Database::getInstance()->getConnect());
        $getCour = $instanceCours->getBestCours($getID,Database::getInstance()->getConnect());
        $getRecentActivites = $instanceCours->recentActivities($getID,Database::getInstance()->getConnect());

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

    $getCategories = categorie::getCategories(Database::getInstance()->getConnect());
    $getCours = $instanceCours->teacherCours($getID,Database::getInstance()->getConnect());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Page Wrapper -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once 'aside.php'; ?>

        <!-- Main Content -->
        <div class="flex-grow">
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
                <h2 class="text-xl font-bold text-indigo-600">My Courses</h2>
            </header>

            <!-- Content Area -->
            <main class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
                    <button 
                        onclick="toggleModal('addCourseModal')" 
                        class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                        Add Course
                    </button>
                </div>

                <!-- Courses List -->
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <?php 

                        if($getCours != null && $getCours->rowCount() > 0){
                            foreach($getCours as $cours){
                                $getDesc = substr($cours['titre'],0,100);
                                $accpted = '';
                                $color = '';
                                if($cours['id_approved'] == true){
                                    $accpted = 'Accepted';
                                    $color = 'green';
                                }else{
                                    $accpted = 'Pending';
                                    $color = 'yellow';
                                }
                                echo '<div class="bg-white shadow-lg rounded-lg p-6 flex flex-col justify-between">
                        <h2 class="text-lg font-bold text-gray-800">'.$cours['titre'].'</h2>
                        <p class="text-gray-600">'.$getDesc.'
                        <h3 class="text-lg bg-white py-3 rounded-full text-sm font-medium text-'.$color.'-600">'.$accpted.'</h3></p>
                        <form action="../../controller/removeCoursController.php" method="POST" class="flex justify-between">
                            <button 
                                type="button"
                                onclick="openEditModal('.$cours['id_cours'].',`'.$cours['titre'].'`, `'.$cours['description'].'`)" 
                                class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                Edit
                            </button>
                            <button 
                                value="'.$cours['id_cours'].'"
                                name="remove"
                                type="submit"
                                class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                                Remove
                            </button>
                        </form>
                    </div>';
                            }
                        }else{
                            echo 'No cours exict!';
                        }
                    
                    ?>
                    <!-- <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-800">Course Title</h2>
                        <p class="text-gray-600 mb-4">Short course description goes here.</p>
                        <div class="flex justify-between">
                            <button 
                                onclick="openEditModal('hello', 'hello', 'hello')" 
                                class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                Edit
                            </button>
                            <button 
                                class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                                Remove
                            </button>
                        </div>
                    </div> -->

                </section>
            </main>
        </div>
    </div>

    <!-- Add Course Modal -->
    <div id="addCourseModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2 max-h-[95vh] overflow-auto">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Add Course</h2>
            <form action="../../controller/addCoursController.php" method="POST" enctype="multipart/form-data">
                <div id="image-content-section" class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Image Upload</label>
                    <input type="file" name="image_content" accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
                </div>
                <div class="mb-4">
                    <label for="course-title" class="block text-gray-700 font-bold mb-2">Course Title</label>
                    <input type="text" id="course-title" name="title" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label for="course-description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea id="course-description" name="description" class="w-full border border-gray-300 rounded-md p-2" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Content Type</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="content_type" value="text" class="form-radio text-indigo-600" checked onchange="toggleContentType()">
                            <span class="ml-2">Text</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="content_type" value="video" class="form-radio text-indigo-600" onchange="toggleContentType()">
                            <span class="ml-2">Video</span>
                        </label>
                    </div>
                </div>
                <div id="text-content-section" class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Content</label>
                    <textarea id="text-content" name="text_content" class="w-full border border-gray-300 rounded-md p-2 h-32"></textarea>
                </div>
                <div id="video-content-section" class="mb-4 hidden">
                    <label class="block text-gray-700 font-bold mb-2">Video Upload</label>
                    <input type="file" name="video_content" accept="video/*" class="w-full border border-gray-300 rounded-md p-2">
                </div>
                <div id="select-categorie" class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Select categoie</label>
                    <select name="categorie" class="w-full border border-gray-300 rounded-md p-2">
                        <option disabled selected  value=""> -- Select Categorie -- </option>
                        <?php

                            if($getCategories != null && $getCategories->rowCount() > 0){
                                foreach($getCategories as $categorie){
                                    echo '<option value="'.$categorie['id_categorie'].'">'.$categorie['name'].'</option>';
                                }
                            }

                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="course-tags" class="block text-gray-700 font-bold mb-2">Tags</label>
                    <input 
                        type="text" 
                        id="course-tags" 
                        class="w-full border border-gray-300 rounded-md p-2" 
                        placeholder="Type to search tags...">
                    <div id="tags-dropdown" class="bg-white border border-gray-300 rounded-md mt-1 max-h-32 overflow-y-auto"></div>
                    <div id="selected-tags" class="mt-2 flex flex-wrap"></div>
                    <!-- Hidden input for tags -->
                    <input type="hidden" name="selected_tags" id="selected-tags-input">
                </div>
                <div class="flex justify-end mt-6">
                    <button 
                        type="button" 
                        onclick="toggleModal('addCourseModal')" 
                        class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 mr-2">
                        Cancel
                    </button>
                    <button type="submit" name="add_course" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                        Add Course
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div id="editCourseModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Course</h2>
            <form action="../../controller/editCoursController.php" method="POST">
                <div class="mb-4">
                    <label for="edit-course-title" class="block text-gray-700 font-bold mb-2">Course Title</label>
                    <input type="text" id="edit-course-title" name="edit_title" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>
                <div class="mb-4">
                    <label for="edit-course-description" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea id="edit-course-description" name="edit_description" class="w-full border border-gray-300 rounded-md p-2" required></textarea>
                </div>
                <div class="flex justify-end mt-6">
                    <button 
                        type="button" 
                        onclick="toggleModal('editCourseModal')" 
                        class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 mr-2">
                        Cancel
                    </button>
                    <button id="edit-course-id" type="submit" name="edit_course" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">
                        Save Changes
                    </button>
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
        function openEditModal(courseId, title, description) {
            // Set values in the edit form
            document.getElementById('edit-course-id').value = courseId;
            document.getElementById('edit-course-title').value = title;
            document.getElementById('edit-course-description').value = description;
            
            // Open the modal
            toggleModal('editCourseModal');
        }
        const existingTags = [
            <?php

                $getTags = tags::getSelectTags(Database::getInstance()->getConnect());
                if($getTags != null && $getTags->rowCount() > 0){
                    foreach($getTags as $tag){
                        echo '`'.$tag['name'].'`,';
                    }
                }
            ?>
        ]; // Example tags
        let selectedTags = new Set();

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function toggleContentType() {
            const textSection = document.getElementById('text-content-section');
            const videoSection = document.getElementById('video-content-section');
            const contentType = document.querySelector('input[name="content_type"]:checked').value;

            if (contentType === 'text') {
                textSection.classList.remove('hidden');
                videoSection.classList.add('hidden');
            } else {
                textSection.classList.add('hidden');
                videoSection.classList.remove('hidden');
            }
        }

        function handleTagInput(event) {
            const input = event.target;
            const dropdown = document.getElementById('tags-dropdown');
            const selectedTagsContainer = document.getElementById('selected-tags');
            const selectedTagsInput = document.getElementById('selected-tags-input');
            const enteredText = input.value.toLowerCase();

            dropdown.innerHTML = '';
            if (enteredText) {
                const filteredTags = existingTags.filter(tag => 
                    tag.toLowerCase().includes(enteredText) && 
                    !selectedTags.has(tag.toLowerCase())
                );
                
                filteredTags.forEach(tag => {
                    const option = document.createElement('div');
                    option.className = 'cursor-pointer hover:bg-gray-200 p-2';
                    option.textContent = tag;
                    option.onclick = () => {
                        if (!selectedTags.has(tag.toLowerCase())) {
                            selectedTags.add(tag.toLowerCase());
                            
                            const tagElement = document.createElement('div');
                            tagElement.className = 'inline-block bg-indigo-600 text-white px-3 py-1 rounded-full m-1';
                            tagElement.dataset.tag = tag.toLowerCase();
                            tagElement.textContent = tag;

                            const removeBtn = document.createElement('span');
                            removeBtn.textContent = ' ✕';
                            removeBtn.className = 'cursor-pointer ml-2';
                            removeBtn.onclick = () => {
                                selectedTags.delete(tag.toLowerCase());
                                tagElement.remove();
                                updateHiddenInput();
                            };

                            tagElement.appendChild(removeBtn);
                            selectedTagsContainer.appendChild(tagElement);
                            updateHiddenInput();
                        }
                        input.value = '';
                        dropdown.innerHTML = '';
                    };
                    dropdown.appendChild(option);
                });
            }
        }

        function updateHiddenInput() {
            const selectedTagsInput = document.getElementById('selected-tags-input');
            selectedTagsInput.value = Array.from(selectedTags).join(',');
        }

        // Add event listener to the tags input
        document.getElementById('course-tags').addEventListener('input', handleTagInput);
    </script>
</body>
</html>