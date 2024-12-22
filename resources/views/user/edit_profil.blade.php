<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Profile</title>
</head>

<body class="bg-gradient-to-br from-sky-400 via-indigo-300 to-purple-400 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-3xl shadow-xl ring-1 ring-gray-300">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Edit Profile</h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-lg text-gray-700 font-medium">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-lg text-gray-700 font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Profile Picture Field -->
                <div class="mb-6">
                    <label for="profile_picture" class="block text-lg text-gray-700 font-medium">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @if (Auth::user()->profile_picture)
                        <div class="mt-4">
                            <img src="{{ asset('uploads/user/' . Auth::user()->profile_picture) }}"alt="Profile Picture"
                                class="w-24 h-24 object-cover rounded-full mx-auto border-4 border-indigo-500 shadow-lg">
                        </div>
                    @endif
                    @error('profile_picture')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-lg text-gray-700 font-medium">New Password
                        (Optional)</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-lg text-gray-700 font-medium">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                    <button type="submit"
                        class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
