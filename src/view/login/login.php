<?php

session_start();

if(isset($_SESSION['id']) && isset($_SESSION['role'])){
    if($_SESSION['role'] == 1){
    }elseif($_SESSION['role'] == 2){
        header('Location: ../teacher/dashboard.php');
    }elseif($_SESSION['role'] == 3){
        header('Location: ../catalogue.php');
    }else{
        header('Location: ../admin/dashboard.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-800 p-4 sm:p-6 md:p-8">
        <!-- Main Container with Glass Effect -->
        <div class="bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden max-w-md w-full animate__animated animate__fadeIn">
            <!-- Logo/Brand Section -->
            <div class="text-center pt-8 pb-4">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Youdemy</h1>
                <p class="text-gray-600 text-sm mt-2">Your Gateway to Knowledge</p>
            </div>

            <!-- Toggle Buttons -->
            <div class="flex justify-center space-x-4 px-6">
                <button id="login-tab" class="w-1/2 py-3 font-semibold text-indigo-600 border-b-2 border-indigo-600 transition-all duration-300 hover:bg-indigo-50">Login</button>
                <button id="signup-tab" class="w-1/2 py-3 font-semibold text-gray-400 border-b-2 border-transparent transition-all duration-300 hover:text-indigo-600 hover:bg-indigo-50">Sign Up</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="p-8 animate__animated animate__fadeIn">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome Back!</h2>
                <form method="POST" action="../../controller/loginController.php">
                    <div class="space-y-5">
                        <div>
                            <label for="login-email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                            <div class="relative">
                                <input name="getEmail" type="email" id="login-email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="your@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="login-password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                            <div class="relative">
                                <input name="getPass" type="password" id="login-password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="••••••••">
                            </div>
                        </div>
                        <button name="loginSubmit" type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all duration-300 transform hover:scale-[0.99]">
                            Login
                        </button>
                    </div>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account? 
                    <button id="switch-to-signup" class="text-indigo-600 font-medium hover:text-indigo-800 transition-colors duration-300">Sign Up</button>
                </p>

                <?php if(isset($_SESSION['logError'])): ?>
                <div class="px-8 pb-6">
                    <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg text-center text-sm">
                        <?php echo $_SESSION['logError']; ?>
                        <?php unset($_SESSION['logError']); ?>
                    </div>
                </div>
            <?php endif; ?>
            </div>

            <!-- Signup Form -->
            <div id="signup-form" class="p-8 hidden animate__animated animate__fadeIn">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>
                <form method="POST" action="../../controller/signupController.php">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="signup-first-name" class="block text-gray-700 text-sm font-medium mb-2">First Name</label>
                                <input name="setFName" type="text" id="signup-first-name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="John" required>
                            </div>
                            <div>
                                <label for="signup-last-name" class="block text-gray-700 text-sm font-medium mb-2">Last Name</label>
                                <input name="setLName" type="text" id="signup-last-name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="Doe" required>
                            </div>
                        </div>
                        <div>
                            <label for="signup-email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                            <input name="setEmail" type="email" id="signup-email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="your@email.com" required>
                        </div>
                        <div>
                            <label for="signup-password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                            <input name="setPass" type="password" id="signup-password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" placeholder="••••••••" required>
                        </div>
                        <div>
                            <label for="signup-user-type" class="block text-gray-700 text-sm font-medium mb-2">I am a</label>
                            <select name="setType" id="signup-user-type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-300" required>
                                <option value="etudiant">Étudiant</option>
                                <option value="prof">Professeur</option>
                            </select>
                        </div>
                        <button name="signupSubmit" type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all duration-300 transform hover:scale-[0.99]">
                            Create Account
                        </button>
                    </div>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    Already have an account? 
                    <button id="switch-to-login" class="text-indigo-600 font-medium hover:text-indigo-800 transition-colors duration-300">Login</button>
                </p>
            </div>

            <?php if(isset($_SESSION['Error'])): ?>
                <div class="px-8 pb-6">
                    <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg text-center text-sm">
                        <?php echo $_SESSION['Error']; ?>
                        <?php unset($_SESSION['Error']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="px-8 pb-6">
                    <div class="bg-green-50 text-green-600 px-4 py-3 rounded-lg text-center text-sm">
                        <?php echo $_SESSION['success']; ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('login-tab');
        const signupTab = document.getElementById('signup-tab');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');
        const switchToSignup = document.getElementById('switch-to-signup');
        const switchToLogin = document.getElementById('switch-to-login');

        function showLogin() {
            loginForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
            loginTab.classList.add('text-indigo-600', 'border-indigo-600');
            loginTab.classList.remove('text-gray-400');
            signupTab.classList.remove('text-indigo-600', 'border-indigo-600');
            signupTab.classList.add('text-gray-400');
        }

        function showSignup() {
            signupForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            signupTab.classList.add('text-indigo-600', 'border-indigo-600');
            signupTab.classList.remove('text-gray-400');
            loginTab.classList.remove('text-indigo-600', 'border-indigo-600');
            loginTab.classList.add('text-gray-400');
        }

        loginTab.addEventListener('click', showLogin);
        signupTab.addEventListener('click', showSignup);
        switchToSignup.addEventListener('click', showSignup);
        switchToLogin.addEventListener('click', showLogin);
    </script>
</body>
</html>