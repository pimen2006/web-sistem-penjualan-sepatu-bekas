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
                    <h2 class="text-2xl font-bold text-gray-800">Product</h2>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Search Bar -->
                    <div class="relative w-full max-w-xs block sm:max-w-sm">
                        <form method="GET" action="{{ route('admin.products') }}">
                            <input type="text" name="search" placeholder="Search..." value="{{ request()->search }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </form>
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

            <div class="flex-grow">

                <!-- Content Section -->
                <div class="flex-1 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-3xl font-bold text-gray-800">Daftar Produk</h2>
                        <a href="{{ route('admin.product-add') }}"
                            class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">Tambah Produk</a>
                    </div>

                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                            role="alert">
                            <strong class="font-bold">Status!</strong>
                            <span class="block sm:inline">{{ session('status') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                                onclick="this.parentElement.remove();">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path
                                        d="M14.348 5.652a.5.5 0 10-.707-.707L10 8.586 6.36 4.945a.5.5 0 00-.707.707L8.586 10l-3.333 3.333a.5.5 0 10.707.707L10 11.414l3.333 3.333a.5.5 0 10.707-.707L11.414 10l3.333-3.333z" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                            <thead>
                                <tr class="bg-blue-100 text-gray-800 text-left">
                                    <th class="py-3 px-4 border-r">ID</th>
                                    <th class="py-3 px-4 border-r">Nama</th>
                                    <th class="py-3 px-4 border-r">Harga</th>
                                    <th class="py-3 px-4 border-r">Harga Diskon</th>
                                    <th class="py-3 px-4 border-r">SKU</th>
                                    <th class="py-3 px-4 border-r">Kategori</th>
                                    <th class="py-3 px-4 border-r">Unggulan</th>
                                    <th class="py-3 px-4 border-r">Stok</th>
                                    <th class="py-3 px-4 border-r">Kuantitas</th>
                                    <th class="py-3 px-4 border-r">gambar</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="hover:bg-blue-50 border-b border-gray-200">
                                        <td class="py-3 px-4 border-r text-center">{{ $product->id }}</td>
                                        <td class="py-3 px-4 border-r">
                                            <div>
                                                <a href="#"
                                                    class="text-blue-600 font-semibold hover:underline">{{ $product->name }}</a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 border-r text-center">${{ $product->regular_price }}</td>
                                        <td class="py-3 px-4 border-r text-center">${{ $product->sale_price }}</td>
                                        <td class="py-3 px-4 border-r text-center">{{ $product->SKU }}</td>
                                        <td class="py-3 px-4 border-r text-center">{{ $product->category->name }}</td>
                                        <td class="py-3 px-4 border-r text-center">
                                            {{ $product->featured == 0 ? 'No' : 'Yes' }}</td>
                                        <td class="py-3 px-4 border-r text-center">{{ $product->stock_status }}</td>
                                        <td class="py-3 px-4 border-r text-center">{{ $product->quantity }}</td>
                                        <td class="py-3 px-4 border-r text-center"><img
                                                src="{{ asset('uploads/product/thumbnails') }}/{{ $product->image }}"
                                                alt="{{ $product->name }}"
                                                class="w-16 h-16 object-cover rounded-lg shadow-md"></td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex justify-center items-center gap-x-2">
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.product-edit', ['id' => $product->id]) }}"
                                                    class="bg-blue-600 text-white py-1 px-3 rounded-lg hover:bg-blue-700">
                                                    Edit
                                                </a>
                                                <!-- Tombol Hapus -->
                                                <form
                                                    action="{{ route('admin.product-delete', ['id' => $product->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-600 text-white py-1 px-3 rounded-lg hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4">
                        {{ $products->links() }}
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

        $("#myFile").on("change", function() {
            const photoInput = $("#myFile")[0];
            const file = this.files[0];
            if (file) {
                $(".imgpreview img").attr("src", URL.createObjectURL(file));
                $(".imgpreview").show();
            }
        });

        $("input[name='name']").on("change", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });

        function StringToSlug(text) {
            return text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    </script>

</body>

</html>
