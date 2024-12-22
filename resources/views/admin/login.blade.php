<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>login</title>
</head>

<body>
    <!-- component -->
    <div class="bg-sky-100 flex justify-center items-center h-screen">
        <!-- Left: Image -->
        <div class="w-1/2 h-screen hidden lg:block">
            <img src="https://img.freepik.com/fotos-premium/imagen-fondo_910766-187.jpg?w=826" alt=""
                class="object-cover w-full h-full">
        </div>
        <!-- Right: Login Form -->
        <div class= "lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
            <h1 class="text-2xl font-semibold mb-4 text-center">Login</h1>
            @if (Session::has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4"
                    role="alert">
                    <span class="font-semibold">{{ Session::get('success') }}</span>
                </div>
            @endif

            @if (Session::has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4" role="alert">
                    <span class="font-semibold">{{ Session::get('error') }}</span>
                </div>
            @endif
            <form action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-600">Email</label>
                    <input type="text" value="{{ old('email') }}" id="email" name="email"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500 @error('email') is-invalid @enderror"
                        autocomplete="off">
                    @error('email')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-800">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500 @error('password') is-invalid @enderror"
                        autocomplete="off">
                    @error('password')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-red-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
