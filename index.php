
<?php

    session_start();
    require_once 'src/classes/database.php';
    require_once 'src/classes/cours.php';



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Transform Your Future Through Learning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Sticky Header with Blur Effect -->
    <header class="fixed w-full px-5 bg-white/80 backdrop-blur-md z-50 border-b border-gray-100">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg"></div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Youdemy</span>
                </a>
                
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="src/view/catalogue.php" class="text-gray-600 hover:text-indigo-600 transition-colors">Courses</a>
                    <a href="#about" class="text-gray-600 hover:text-indigo-600 transition-colors">About</a>
                    <a href="#contact" class="text-gray-600 hover:text-indigo-600 transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <?php

                        if(isset($_SESSION['id']) && isset($_SESSION['role']) && !empty($_SESSION['id']) && !empty($_SESSION['role'])){
                            if($_SESSION['role'] == 1){
                                echo '<a href="src/view/admin/dashboard.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Dashboard</a>';
                            }elseif($_SESSION['role'] == 1){
                                echo '<a href="src/view/teacher/dashboard.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Dashboard</a>';
                            }else{
                                echo '<a href="src/view/catalogue.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Catalogue</a>';
                            }
                        }else{
                            echo '<a href="src/view/login/login.php" class="px-4 py-2 text-gray-600 hover:text-indigo-600 transition-colors">Log In</a>
                    <a href="src/view/login/login.php" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-600/20">Sign Up Free</a>';
                        }


                    ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section with Gradient Background -->
    <section class="min-h-screen pt-40 pb-20 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center space-y-8 animate__animated animate__fadeIn">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Transform</span> Your Future Through Learning
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">Join millions of learners worldwide and master the skills you need to shape your tomorrow.</p>
                
                <div class="max-w-2xl mx-auto">
                    <form method="GET" action="src/view/catalogue.php" class="relative">
                        <input name="searchValue" type="text" placeholder="What do you want to learn?" 
                               class="w-full px-6 py-4 bg-white rounded-full shadow-lg border border-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-600/20" />
                        <button name="search" class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition-colors">
                            Search
                        </button>
                    </form>
                </div>

                <div class="flex items-center justify-center gap-12 pt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">15K+</div>
                        <div class="text-gray-600">Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">200K+</div>
                        <div class="text-gray-600">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">92%</div>
                        <div class="text-gray-600">Success rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Popular Courses Section -->
<section id="courses" class="py-20">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl font-bold mb-4">Trending Courses</h2>
                <p class="text-gray-600">Explore our most popular courses chosen by thousands of learners.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
            <?php

                    $getBestCours = cours::bestThreeCours(Database::getInstance()->getConnect());
                    if($getBestCours != null && $getBestCours->rowCount() > 0){
                    foreach($getBestCours as $cours){
                        $getDesc = substr($cours['titre'],0,100);
                        echo '<div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300">
                        <div class="relative">
                            <img src="public/img/coursImage/'.$cours['imgSrc'].'" alt="Course Title" class="w-full h-48 object-cover" />
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                                '.$cours['name'].'
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2 hover:text-indigo-600 transition-colors">'.$cours['titre'].'</h3>
                            <p class="text-gray-600 mb-4">'.$getDesc.'</p>
                            <div class="flex items-center justify-between">
                                
                                <a target="_blank" href="src/view/cour.php?cours='.$cours['id_cours'].'" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition-colors">
                                    Get Course
                                </a>
                            </div>
                            <div class="text-sm text-gray-500 mt-4">
                                Created: '.$cours['date_create'].'
                            </div>
                        </div>
                    </div>';
                    }
                }else{
                    echo 'No cours exict yet!';
                }
            
                ?>


                <!-- Course Card (simplified) -->





            </div>
        </div>
    </section>





            <!-- About Section -->
<section id="about" class="py-20 bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-bold">
                        <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">About Youdemy</span>
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        Youdemy is a leading online learning platform dedicated to transforming education worldwide. We believe in making quality education accessible to everyone, everywhere.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-600/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Expert Instructors</h3>
                                <p class="text-gray-600">Learn from industry professionals and experienced educators.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-600/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Flexible Learning</h3>
                                <p class="text-gray-600">Study at your own pace with lifetime access to courses.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-600/10 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Practical Skills</h3>
                                <p class="text-gray-600">Gain real-world skills with hands-on projects and exercises.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="/api/placeholder/600/400" alt="About Youdemy" class="rounded-2xl shadow-lg" />
                    <div class="absolute -bottom-6 -right-6 bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-indigo-600/10 p-3 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">10+ Years</div>
                                <div class="text-gray-600">of Excellence</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-3xl font-bold mb-4">Get in Touch</h2>
                            <p class="text-gray-600">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="bg-indigo-600/10 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Our Location</h3>
                                    <p class="text-gray-600">123 Learning Street, Education City, 12345</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="bg-indigo-600/10 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Email Us</h3>
                                    <p class="text-gray-600">support@youdemy.com</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="bg-indigo-600/10 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Call Us</h3>
                                    <p class="text-gray-600">+1 234 567 890</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8">
                            <h3 class="font-semibold text-gray-900 mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                    </a>
                                <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>


            

                    <!-- Contact Form -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-600/20" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-600/20" />
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-600/20" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <select class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-600/20">
                                    <option>Choose a subject</option>
                                    <option>Course Information</option>
                                    <option>Technical Support</option>
                                    <option>Partnership Inquiry</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-600/20"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="bg-gray-900 text-gray-400">
        <div class="container mx-auto px-4">
            <!-- Newsletter Section -->
            <div class="py-12 border-b border-gray-800">
                <div class="max-w-2xl mx-auto text-center">
                    <h3 class="text-2xl font-bold text-white mb-4">Subscribe to Our Newsletter</h3>
                    <p class="mb-6">Stay updated with the latest courses and learning resources.</p>
                    <form class="flex gap-4 max-w-md mx-auto">
                        <input type="email" placeholder="Enter your email" 
                               class="flex-1 px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-400 focus:outline-none focus:border-indigo-600" />
                        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Footer Content -->
            <div class="py-12 grid md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg"></div>
                        <span class="text-xl font-bold text-white">Youdemy</span>
                    </div>
                    <p class="mb-6">Empowering learners worldwide to achieve their dreams through quality education.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <!-- Add other social media icons similarly -->
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Quick Links</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Our Courses</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Contact Info</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>123 Learning Street, Education City, 12345</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>support@youdemy.com</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>+1 234 567 890</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="py-6 border-t border-gray-800 text-center">
                <p>&copy; 2025 Youdemy. All rights reserved.</p>
            </div>
        </div>
    </footer>
    </body>
</html>