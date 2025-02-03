<aside class="w-64 h-[100vh] bg-gradient-to-b from-indigo-600 to-indigo-800 text-white flex flex-col">
            <div class="p-6 border-b border-indigo-500/30">
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold">Youdemy Admin</h1>
                </div>
            </div>
            <nav class="flex-grow space-y-1 p-4">
                <a href="dashboard.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-indigo-500/30">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Statistiques</span>
                </a>
                <a href="accepter.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-indigo-500/30">
                    <i class="fas fa-check-circle w-5"></i>
                    <span>Accepter les cours</span>
                </a>
                <a href="users.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-indigo-500/30">
                    <i class="fas fa-users w-5"></i>
                    <span>Gérer les utilisateurs</span>
                </a>
                <a href="tags.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-indigo-500/30">
                    <i class="fas fa-tags w-5"></i>
                    <span>Manage Tags</span>
                </a>
            </nav>
            <form method="POST" class="p-4">
                <button name="logout" class="w-full bg-red-500 hover:bg-red-600 py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </button>
            </form>

        </aside>