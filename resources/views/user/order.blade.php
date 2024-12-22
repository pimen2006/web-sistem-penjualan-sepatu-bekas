<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Penjualan Sepatu Bekas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-sky-300 via-indigo-200 to-purple-300">

    <header class="bg-white sticky top-0 z-50 rounded-lg shadow-lg">
        <nav class="w-11/12 md:container mx-auto px-5 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-indigo-600">Second Step</h1>
            </div>
            <ul class="lg:flex gap-8 px-5 text-gray-800 font-bold hidden">
                <a href="{{ route('home') }}">
                    <li class="hover:bg-slate-300 rounded-lg p-2">Home</li>
                </a>
                <a href="{{ route('shop.category', ['category_id' => 0]) }}">
                    <li class="hover:bg-slate-300 rounded-lg p-2">Shop
                    </li>
                </a>
                <a href="{{ route('orders') }}">
                    <li class="hover:bg-slate-300 rounded-lg p-2">pesanan</li>
                </a>
            </ul>
            <div class="flex items-center gap-4">
                <div class="relative inline-block">
                    <a href="{{ route('keranjang') }}" class="inline-flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-800 hover:text-gray-900 transition" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M21.6,7.8C21.2,7.3,20.6,7,20,7H8.6L8,3.6C7.8,2.7,7,2,6,2H4C2.9,2,2,2.9,2,4s0.9,2,2,2h0.3L6,14.4c0.2,1,1,1.6,2,1.6h10c0.9,0,1.6-0.6,1.9-1.4l2-5C22.1,9,22,8.4,21.6,7.8z" />
                            <circle cx="10" cy="20" r="2"></circle>
                            <circle cx="16" cy="20" r="2"></circle>
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <div class="relative">
                    <button id="profileButton" class="flex items-center focus:outline-none gap-2 ">
                        <img src="{{ asset('uploads/user/' . Auth::user()->profile_picture) }}" alt="Profile Picture"
                            class=" object-cover w-8 h-8 rounded-full">
                        <span class="font-bold text-gray-800 hidden lg:block">{{ Auth::user()->name }}</span>
                    </button>

                    <div id="profileDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                        <ul class="py-1">
                            <li><a href="{{ route('profile') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Profile</a>
                            </li>
                            <li><a href="{{ route('account.logout') }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a></li>
                        </ul>
                    </div>
                </div>

                <div class="lg:hidden block buttonTongle">
                    <button>
                        <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <div class="MobileMenu hidden lg:hidden">
            <ul class="divide-y divide-slate-800 text-gray-800 font-semibold text-center">
                <a href="{{ route('home') }}">
                    <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg">Home</li>
                </a>
                <a href="{{ route('shop.category', ['category_id' => 0]) }}">
                    <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg">Shop</li>
                </a>
                <a href="{{ route('orders') }}">
                    <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg">pesamam</li>
                </a>
            </ul>
        </div>
    </header>

    <!-- Order Section -->
    <section class="container mx-auto p-6 mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Alamat Pengiriman -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-6">Alamat Pengiriman</h2>
            <form class="space-y-4" action="{{ route('order') }}" method="POST">
                @csrf
                @if ($address)
                    <div class="bg-slate-100 p-6 rounded-lg shadow-lg max-w-lg mx-auto mt-8">
                        <p class="text-lg font-semibold text-gray-800">{{ $address->name }}</p>
                        <p class="text-gray-600 mt-1">{{ $address->phone }}</p>
                        <p class="text-gray-600 mt-1">{{ $address->city }}, {{ $address->state }}</p>
                        <p class="text-gray-600 mt-2">{{ $address->locality }}</p>
                        <p class="text-gray-600 mt-2">{{ $address->address }}</p>
                        <p class="text-gray-600 mt-1">{{ $address->zip }}</p>
                        <p class="text-gray-600 mt-1">{{ $address->landmark }}</p>
                        <a href="{{ route('address.edit') }}"
                            class="inline-block mt-4 text-blue-500 hover:text-blue-700 font-semibold">
                            Edit Alamat Pengirim
                        </a>
                    </div>
                @else
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            placeholder="Masukkan nama penerima">
                        @error('name')
                            <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" required value="{{ old('phone') }}"
                            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            placeholder="Masukkan nomor telepon">
                        @error('phone')
                            <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" id="state" name="state" required
                                value="{{ old('state') }}"
                                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                placeholder="Masukkan provinsi">
                            @error('state')
                                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="city"
                                class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                            <input type="text" id="city" name="city" required
                                value="{{ old('city') }}"
                                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                placeholder="Masukkan kota/kabupaten">
                            @error('city')
                                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="locality" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <input type="tel" id="locality" name="locality" required
                                value="{{ old('locality') }}"
                                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                placeholder="Masukkan kecamatan">
                            @error('locality')
                                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <input type="text" id="zip" name="zip" required
                                value="{{ old('zip') }}"
                                class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                placeholder="Masukkan kode pos Anda">
                            @error('zip')
                                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea id="address" name="address" required value="{{ old('address') }}"
                            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            placeholder="Masukkan alamat lengkap Anda"></textarea>
                        @error('address')
                            <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="landmark" class="block text-sm font-medium text-gray-700">tanda pengenal</label>
                        <input type="text" id="landmark" name="landmark" required value="{{ old('landmark') }}"
                            class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            placeholder="Masukkan landmark Anda">
                        @error('landmark')
                            <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-blue-600 mb-6">Ringkasan Pesanan</h2>

            <!-- Daftar Barang -->
            <div class="space-y-6">
                @foreach ($items as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('uploads/product/thumbnails') }}/{{ $item->model->image }}"
                                alt="" class="w-20 h-20 object-cover rounded">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800">{{ $item->name }},
                                    {{ $item->qty }}</h4>
                                <p class="text-gray-600">{{ $item->short_description }}</p>
                            </div>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">{{ $item->subtotal() }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Ringkasan Harga -->
            <div class="mt-6 space-y-4 border-t pt-6">
                <div class="flex justify-between text-lg font-medium">
                    <span>Subtotal:</span>
                    <span>{{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>

                <div class="flex justify-between text-lg font-medium">
                    <span>Ongkir:</span>
                    <span>free</span>
                </div>

                <div class="flex justify-between text-xl font-bold text-blue-600">
                    <span>Pajak:</span>
                    <span>{{ number_format($taxTotal, 2, ',', '.') }}</span>
                </div>

                <hr class="border-t border-gray-300">

                <div class="flex justify-between text-lg font-medium">
                    <span>Ongkir:</span>
                    <span>Rp {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold text-blue-600 mb-4">Pilih Metode Pembayaran</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <input type="radio" id="mode1" name="mode" value="cod"
                            class="h-5 w-5 text-blue-600" checked>
                        <label for="mode1" class="text-gray-700 font-medium">Cash on Delivery (COD)</label>
                    </div>
                    <div class="flex items-center space-x-4">
                        <input type="radio" id="mode2" name="mode" value="card"
                            class="h-5 w-5 text-blue-600">
                        <label for="mode2" class="text-gray-700 font-medium">Kartu Kredit/Debit</label>
                    </div>
                </div>
            </div>

            <button class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all">
                Konfirmasi Pesanan
            </button>

        </div>
        </form>
    </section>

    <footer class="bg-gradient-to-r from-purple-600 via-indigo-600 to-sky-600 text-white py-10">
        <div class="container mx-auto px-6 lg:px-20 grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Section 1: Logo & About -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Second Step</h2>
                <p class="text-gray-200 text-sm">
                    Menyediakan sepatu berkualitas yang dirancang untuk kenyamanan dan ketahanan di segala medan.
                    Pilihan kami mencakup berbagai jenis sepatu yang cocok untuk pendakian, aktivitas outdoor, dan gaya
                    hidup aktif Anda.
                </p>
                <div class="flex gap-4 mt-4">
                    <!-- Instagram -->
                    <a href="#" class="text-white hover:text-gray-300">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.17.056 1.96.24 2.41.399a4.92 4.92 0 0 1 1.67 1.1 4.92 4.92 0 0 1 1.1 1.67c.16.45.343 1.24.399 2.41.059 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.056 1.17-.24 1.96-.399 2.41a4.92 4.92 0 0 1-1.1 1.67 4.92 4.92 0 0 1-1.67 1.1c-.45.16-1.24.343-2.41.399-1.266.059-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.056-1.96-.24-2.41-.399a4.92 4.92 0 0 1-1.67-1.1 4.92 4.92 0 0 1-1.1-1.67c-.16-.45-.343-1.24-.399-2.41C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.056-1.17.24-1.96.399-2.41a4.92 4.92 0 0 1 1.1-1.67 4.92 4.92 0 0 1 1.67-1.1c.45-.16 1.24-.343 2.41-.399C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.053.072c-1.276.059-2.255.24-3.065.51A7.89 7.89 0 0 0 .582 2.54a7.89 7.89 0 0 0-1.959 2.24c-.27.81-.451 1.79-.51 3.065-.058 1.279-.072 1.688-.072 4.948s.014 3.668.072 4.948c.059 1.276.24 2.255.51 3.065a7.89 7.89 0 0 0 2.24 2.24c.81.27 1.79.451 3.065.51 1.279.058 1.688.072 4.948.072s3.668-.014 4.948-.072c1.276-.059 2.255-.24 3.065-.51a7.89 7.89 0 0 0 2.24-2.24c.27-.81.451-1.79.51-3.065.058-1.279.072-1.688.072-4.948s-.014-3.668-.072-4.948c-.059-1.276-.24-2.255-.51-3.065a7.89 7.89 0 0 0-2.24-2.24c-.81-.27-1.79-.451-3.065-.51C15.668.014 15.259 0 12 0z" />
                            <circle cx="12" cy="12" r="3.2" />
                            <circle cx="16.05" cy="7.95" r="1.05" />
                        </svg>
                    </a>
                    <!-- Facebook -->
                    <a href="#" class="text-white hover:text-gray-300">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path
                                d="M22.676 0H1.324C.593 0 0 .593 0 1.324v21.352C0 23.407.593 24 1.324 24h11.495v-9.294H9.847V11.5h2.972V8.86c0-2.935 1.785-4.54 4.393-4.54 1.248 0 2.323.093 2.635.135v3.058l-1.808.001c-1.417 0-1.692.674-1.692 1.662v2.178h3.384l-.441 3.206h-2.942V24h5.76c.73 0 1.324-.593 1.324-1.324V1.324C24 .593 23.407 0 22.676 0z" />
                        </svg>
                    </a>
                    <!-- Twitter -->
                    <a href="#" class="text-white hover:text-gray-300">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path
                                d="M23.954 4.569c-.885.394-1.83.658-2.825.775 1.014-.607 1.794-1.566 2.163-2.723-.95.564-2.005.973-3.127 1.194-.896-.952-2.173-1.548-3.594-1.548-2.725 0-4.933 2.209-4.933 4.933 0 .39.045.765.127 1.124C7.69 8.094 4.066 6.13 1.64 3.161c-.427.732-.666 1.581-.666 2.491 0 1.723.873 3.241 2.188 4.131-.807-.026-1.566-.247-2.228-.616v.062c0 2.404 1.712 4.408 3.977 4.865-.417.113-.857.173-1.309.173-.319 0-.633-.031-.935-.087.633 1.977 2.472 3.415 4.646 3.455-1.703 1.333-3.85 2.126-6.186 2.126-.403 0-.799-.025-1.191-.071C2.338 20.326 5.168 21 8.218 21c9.858 0 15.231-8.164 15.231-15.231 0-.232-.006-.463-.017-.693.975-.701 1.818-1.568 2.488-2.56z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Section 2: Quick Links -->
            <div>
                <h2 class="text-xl font-bold mb-4">Quick Links</h2>
                <ul class="space-y-2 text-gray-200 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-gray-100">Home</a></li>
                    <li><a href="{{ route('shop.category', ['category_id' => 0]) }}"
                            class="hover:text-gray-100">Shop</a></li>
                    <li><a href="{{ route('pesanan') }}" class="hover:text-gray-100">Orders</a></li>
                </ul>
            </div>

            <!-- Section 3: Newsletter -->
            <div>
                <h2 class="text-xl font-bold mb-4">Contact Us</h2>
                <p class="text-gray-200 text-sm mb-4">Reach out to us through the following channels:</p>
                <div class="flex flex-col gap-4">
                    <a href="tel:+1234567890" class="flex items-center text-gray-200 hover:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M6.62 10.79a15.055 15.055 0 006.59 6.59l2.2-2.2a1.02 1.02 0 011.1-.24c1.2.48 2.52.75 3.88.75a1 1 0 011 1v3.74a1 1 0 01-1 1C10.27 22 2 13.73 2 4.99a1 1 0 011-1h3.75a1 1 0 011 1c0 1.35.27 2.67.75 3.88a1 1 0 01-.24 1.1l-2.2 2.2z" />
                        </svg>
                        +123 456 7890
                    </a>
                    <a href="https://wa.me/1234567890" class="flex items-center text-gray-200 hover:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.78 11.78 0 0012 0a11.79 11.79 0 00-8.51 20.17L0 24l3.89-3.48A11.79 11.79 0 0012 24h.06A11.78 11.78 0 0020.52 3.48zM12 21.54a9.71 9.71 0 01-5.23-1.49l-.37-.23-3.1.82.83-3-.24-.38A9.72 9.72 0 1112 21.54zm5.26-7.43c-.3-.15-1.77-.87-2.05-.97s-.48-.15-.68.15-.77.97-.95 1.17-.35.22-.65.07a8.03 8.03 0 01-2.35-1.45 8.35 8.35 0 01-1.54-1.89c-.16-.3 0-.46.11-.62.12-.15.3-.35.45-.53.15-.17.2-.3.3-.5.1-.22.05-.38-.03-.53s-.68-1.65-.93-2.26c-.24-.6-.48-.52-.68-.53h-.57a1.1 1.1 0 00-.8.38c-.28.3-1.05 1.02-1.05 2.49s1.08 2.87 1.24 3.07c.15.2 2.11 3.22 5.13 4.52.72.31 1.28.5 1.72.64.72.23 1.37.2 1.88.12.57-.08 1.77-.72 2.02-1.41.25-.7.25-1.3.18-1.41-.06-.12-.24-.2-.54-.35z" />
                        </svg>
                        +123 456 7890
                    </a>
                    <div class="flex items-center text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5c-1.4 0-2.5-1.1-2.5-2.5S10.6 6.5 12 6.5s2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z" />
                        </svg>
                        123 Mountain St, Cityville, Country
                    </div>
                </div>
            </div>

        </div>
        <div class="bg-indigo-800 text-gray-200 py-4 text-center mt-8">
            <p>&copy; 2024 Second Step. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        const buttonTongle = document.querySelector('.buttonTongle');
        const MobileMenu = document.querySelector('.MobileMenu');

        buttonTongle.addEventListener('click', function() {
            MobileMenu.classList.toggle('hidden');
        })

        profileButton.addEventListener('click', function() {
            profileDropdown.classList.toggle('hidden');
        });
    </script>

</body>

</html>