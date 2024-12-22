<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>edit alamat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-sky-300 via-indigo-200 to-purple-300">

    <header class="bg-white sticky top-0 z-50 rounded-lg shadow-lg">
        <nav class="w-11/12 md:container mx-auto px-5 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-indigo-600">Second Step</h1>
            </div>
            <ul class="lg:flex gap-8 px-5 text-gray-800 font-bold hidden">
                <li class="hover:bg-slate-300 rounded-lg p-2"><a href="{{ route('home') }}">Home</a></li>
                <li class="hover:bg-slate-300 rounded-lg p-2"><a
                        href="{{ route('shop.category', ['category_id' => 0]) }}">Shop</a></li>
                <li class="hover:bg-slate-300 rounded-lg p-2"><a href="{{ route('orders') }}">pesanan</a></li>
                <li class="hover:bg-slate-300 rounded-lg p-2"><a href="#">Contact</a></li>
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
                    <button id="profileButton" class="flex items-center focus:outline-none gap-2">
                        <svg class="w-8 h-8 text-gray-800" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                            </path>
                        </svg>
                        <span class="font-bold text-gray-800 hidden lg:block">{{ Auth::user()->name }}</span>
                    </button>

                    <div id="profileDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                        <ul class="py-1">
                            <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Profile</a>
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
                <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg"><a
                        href="{{ route('home') }}">Home</a></li>
                <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg"><a
                        href="{{ route('shop.category', ['category_id' => 0]) }}">Shop</a></li>
                <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg"><a href="{{ route('orders') }}">pesamam</a></li>
                <li class="py-4 px-3 bg-white hover:bg-slate-400 cursor-pointer rounded-lg"><a
                        href="#">Contact</a></li>
            </ul>
        </div>
    </header>

    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Alamat Pengirim</h2>
        <form action="{{ route('address.update') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block font-semibold">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $address->name) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="phone" class="block font-semibold">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $address->phone) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="state" class="block font-semibold">Provinsi</label>
                    <input type="text" id="state" name="state" value="{{ old('state', $address->state) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="city" class="block font-semibold">Kota/Kabupaten</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $address->city) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="locality" class="block font-semibold">kecamatan</label>
                    <input type="text" id="locality" name="locality"
                        value="{{ old('locality', $address->locality) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="zip" class="block font-semibold">Kode Pos</label>
                    <input type="text" id="zip" name="zip" value="{{ old('zip', $address->zip) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="address" class="block font-semibold">Alamat</label>
                    <textarea id="address" name="address"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>{{ old('address', $address->address) }}</textarea>
                </div>

                <div>
                    <label for="landmark" class="block font-semibold">Tanda Pengenal</label>
                    <input type="text" id="landmark" name="landmark"
                        value="{{ old('landmark', $address->landmark) }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Perbarui Alamat
            </button>
        </form>
    </div>

</body>

</html>
