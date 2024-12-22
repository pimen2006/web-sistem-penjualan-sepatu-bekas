<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categori Admin E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.7.0/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.61.1/dist/tabler-icons.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <!-- Sidebar (Desktop & Mobile) -->
        <aside id="sidebar"
            class="lg:block lg:w-52 w-full h-full bg-gradient-to-b from-blue-800 to-blue-600 text-white shadow-lg fixed lg:relative lg:translate-x-0 -translate-x-full transition-transform duration-200 z-10">
            <div class="flex flex-col p-6 items-center">
                <h1 class="text-2xl font-bold mt-20">Second Step</h1>
                <ul class="mt-8 space-y-4">
                    <li><a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-home mr-3"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.category') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-category mr-3"></i> Category</a></li>
                    <li><a href="{{ route('admin.products') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-box mr-3"></i> Products</a></li>
                    <li><a href="{{ route('admin.order') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-shopping-cart mr-3"></i> Orders</a></li>
                    <li><a href="{{ route('admin.customers') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-users mr-3"></i> Customers</a></li>
                    <li><a href="{{ route('admin.logout') }}"
                            class="flex items-center px-4 py-3 hover:bg-blue-700 rounded-lg"><i
                                class="tabler tabler-logout mr-3"></i> Logout</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
            <!-- Top Navbar -->
            <header class="bg-white shadow-md p-5 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center space-x-4">
                    <!-- Toggle Sidebar Button (Hamburger) -->
                    <button id="toggleSidebarButton" class="text-gray-500 block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" class="tabler tabler-menu">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12h18M3 6h18M3 18h18"></path>
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800">order</h2>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search Bar -->
                    <div class="relative w-full max-w-xs block sm:max-w-sm">
                        <input type="text" placeholder="Search..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="profileButton" class="flex items-center focus:outline-none gap-2">
                            <img src="{{ asset('uploads/admin/' . Auth::guard('admin')->user()->profile_picture) }}"
                                alt="Profile Picture" class="object-cover w-9 h-9 rounded-full">
                            <span
                                class="font-bold text-gray-800 hidden lg:block">{{ Auth::guard('admin')->user()->name }}</span>
                        </button>

                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                            <ul class="py-1">
                                <li><a href="{{ route('admin.profile') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Profile</a></li>
                                <li><a href="{{ route('admin.logout') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 flex flex-col">

                <!-- Profile Section -->
                <div class="flex justify-center items-center flex-grow">
                    <div class="max-w-lg bg-white p-8 rounded-3xl shadow-xl ring-1 ring-gray-300 w-full">
                        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Admin Profile</h2>

                        <div class="flex flex-col items-center">
                            <!-- Profile Picture -->
                            @if (Auth::guard('admin')->user()->profile_picture)
                                <img src="{{ asset('uploads/admin/' . Auth::guard('admin')->user()->profile_picture) }}"
                                    alt="Profile Picture"
                                    class="w-24 h-24 object-cover rounded-full border-4 border-indigo-500 shadow-lg">
                            @else
                                <div
                                    class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                                    No Image
                                </div>
                            @endif

                            <!-- Profile Info -->
                            <div class="mt-6 text-center">
                                <p class="text-lg font-medium text-gray-700">Name:
                                    {{ Auth::guard('admin')->user()->name }}</p>
                                <p class="text-lg font-medium text-gray-700">Email:
                                    {{ Auth::guard('admin')->user()->email }}</p>
                            </div>

                            <!-- Edit Profile Button -->
                            <div class="mt-8">
                                <a href="{{ route('admin.profile.edit') }}"
                                    class="bg-indigo-600 text-white py-2 px-6 rounded-lg hover:bg-indigo-700 hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const toggleSidebarButton = document.getElementById('toggleSidebarButton');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        toggleSidebarButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });

        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
        });
    </script>

</body>

</html>
