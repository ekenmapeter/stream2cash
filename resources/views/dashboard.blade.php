<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stream2Cash Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQ6bCgJp10x9P7G/CqR1x+L56E6JgG/32E5f/n5h5u6wN5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 flex flex-col lg:flex-row min-h-screen">

    <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 p-2 text-white bg-blue-800 rounded-md">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out bg-gray-800 w-64 flex flex-col shadow-lg z-40">
        <div class="p-6 text-2xl font-bold text-white text-center">
            Stream2Cash
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-4 space-y-2">
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-home w-5"></i>
                <span>Home</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-blue-700 text-white">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-wallet w-5"></i>
                <span>Wallet</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-list-check w-5"></i>
                <span>Tasks</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-user-circle w-5"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-money-bill-transfer w-5"></i>
                <span>Withdrawal</span>
            </a>
        </nav>

        <!-- User and Logout -->
        <div class="p-4 border-t border-gray-700">
            <div class="mb-4">
                <div class="text-sm text-gray-400">username</div>
                <div class="text-xs text-gray-500">Last Login: 45 minutes ago</div>
            </div>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-red-400 hover:bg-gray-700 transition-colors duration-200">
                <i class="fa-solid fa-right-from-bracket w-5"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-grow p-4 lg:ml-64 flex flex-col lg:flex-row gap-6">

        <!-- Main Content Area -->
        <main class="flex-grow flex flex-col gap-6">
            <!-- User Dashboard Header -->
            <header class="p-6 pt-0">
                <h1 class="text-2xl font-bold mb-1">User Dashboard</h1>
                <p class="text-sm text-gray-400">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
            </header>

            <!-- Stats Section -->
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-gray-800 p-6 rounded-xl flex items-center justify-between shadow-md">
                    <div>
                        <div class="text-sm text-gray-400">Available Task</div>
                        <div class="text-4xl font-semibold mt-1">34</div>
                    </div>
                    <div class="bg-blue-700 p-4 rounded-full text-white text-xl">
                        <i class="fa-solid fa-list-ul"></i>
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl flex items-center justify-between shadow-md">
                    <div>
                        <div class="text-sm text-gray-400">Complete Task</div>
                        <div class="text-4xl font-semibold mt-1">4</div>
                    </div>
                    <div class="bg-blue-700 p-4 rounded-full text-white text-xl">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl flex items-center justify-between shadow-md">
                    <div>
                        <div class="text-sm text-gray-400">Withdrawal</div>
                        <div class="text-4xl font-semibold mt-1">15</div>
                    </div>
                    <div class="bg-blue-700 p-4 rounded-full text-white text-xl">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl flex items-center justify-between shadow-md">
                    <div>
                        <div class="text-sm text-gray-400">Wallet Balance</div>
                        <div class="text-4xl font-semibold mt-1">₪15,000</div>
                    </div>
                    <div class="bg-blue-700 p-4 rounded-full text-white text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
            </section>

            <!-- Recent History Section -->
            <section class="bg-gray-800 p-6 rounded-xl shadow-lg">
                <header class="mb-4">
                    <h2 class="text-xl font-semibold">Recent History</h2>
                    <p class="text-sm text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                </header>
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4">Amount</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4">
                    <a href="#" class="text-blue-400 hover:underline">View More</a>
                </div>
            </section>

            <!-- Recent Withdrawal Section -->
            <section class="bg-gray-800 p-6 rounded-xl shadow-lg">
                <header class="mb-4">
                    <h2 class="text-xl font-semibold">Recent Withdrawal</h2>
                    <p class="text-sm text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                </header>
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4">Amount</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">Join our Patreon</td>
                                <td class="py-3 px-4">Join our Patreon channel to get design</td>
                                <td class="py-3 px-4">₪ 100</td>
                                <td class="py-3 px-4 text-green-400">Completed</td>
                                <td class="py-3 px-4">19/08/2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4">
                    <a href="#" class="text-blue-400 hover:underline">View More</a>
                </div>
            </section>

        </main>

        <!-- Recent Tasks Sidebar (Right) -->
        <aside class="w-full lg:w-96 flex-shrink-0 bg-gray-800 p-6 rounded-xl shadow-lg h-fit">
            <header class="mb-4">
                <h2 class="text-xl font-semibold">Recent Tasks</h2>
            </header>
            <div class="space-y-4">
                <!-- Task Item -->
                <div class="flex items-center space-x-3 bg-gray-900 p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="https://placehold.co/80x80/0000FF/FFFFFF?text=Video" alt="Video thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold">Video trash 2 min watch time generate</div>
                        <p class="text-xs text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-yellow-500 font-semibold">₪100</span>
                            <span class="text-xs text-red-500 font-semibold">Not Completed</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 bg-gray-900 p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="https://placehold.co/80x80/0000FF/FFFFFF?text=Video" alt="Video thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold">Video trash 2 min watch time generate</div>
                        <p class="text-xs text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-green-500 font-semibold">₪100</span>
                            <span class="text-xs text-green-500 font-semibold">Completed</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 bg-gray-900 p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="https://placehold.co/80x80/0000FF/FFFFFF?text=Video" alt="Video thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold">Video trash 2 min watch time generate</div>
                        <p class="text-xs text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-green-500 font-semibold">₪100</span>
                            <span class="text-xs text-green-500 font-semibold">Completed</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 bg-gray-900 p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="https://placehold.co/80x80/0000FF/FFFFFF?text=Video" alt="Video thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold">Video trash 2 min watch time generate</div>
                        <p class="text-xs text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-green-500 font-semibold">₪100</span>
                            <span class="text-xs text-green-500 font-semibold">Completed</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 bg-gray-900 p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="https://placehold.co/80x80/0000FF/FFFFFF?text=Video" alt="Video thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold">Video trash 2 min watch time generate</div>
                        <p class="text-xs text-gray-400 mt-1">Join our Patreon channel to get design courses, source AE files and design atreon.com..........</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-yellow-500 font-semibold">₪100</span>
                            <span class="text-xs text-red-500 font-semibold">Not Completed</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                <a href="#" class="text-blue-400 hover:underline">View More</a>
            </div>
        </aside>

    </div>

    <!-- Footer -->
    <footer class="p-4 text-center text-gray-400 text-sm">
        Copyright © 2025 Stream2Cash. All rights reserved.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');

            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (event) => {
                if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Prevent scroll when sidebar is open on mobile
            const body = document.body;
            new MutationObserver(() => {
                if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) {
                    body.style.overflow = 'hidden';
                } else {
                    body.style.overflow = '';
                }
            }).observe(sidebar, { attributes: true, attributeFilter: ['class'] });

        });
    </script>

</body>
</html>
