<aside class="min-w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white flex flex-col">
            <div class="p-8 text-center border-b border-indigo-500/30">
                <h1 class="text-2xl font-bold tracking-wider">Youdemy</h1>
            </div>
            <nav class="flex-grow py-6">
                <a href="dashboard.php" class="flex items-center px-8 py-4 text-lg hover:bg-indigo-500/50 transition-colors">
                    <i class="fas fa-chart-line w-6 mr-3"></i>
                    Dashboard
                </a>
                <a href="students.php" class="flex items-center px-8 py-4 text-lg hover:bg-indigo-500/50 transition-colors">
                    <i class="fas fa-users w-6 mr-3"></i>
                    Students
                </a>
                <a href="cours.php" class="flex items-center px-8 py-4 text-lg hover:bg-indigo-500/50 transition-colors">
                    <i class="fas fa-book w-6 mr-3"></i>
                    My Courses
                </a>
            </nav>
            <form method="post" class="p-6">
                <button name="logout" class="w-full bg-red-500 py-3 px-4 rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i>
                    Log Out
                </button>
            </form>
        </aside>