<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Edit Kategori</h2>

        <form action="{{ route('admin.category-update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $category->id }}"/>
            <!-- Nama Kategori -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Nama
                    Kategori</label>
                <input type="text" id="name" name="name" value="{{ $category->name }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('name')
                    <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Slug Kategori -->
            <div class="mb-4">
                <label for="slug" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Slug
                    Kategori</label>
                <input type="text" id="slug" name="slug" value="{{ $category->slug }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('slug')
                    <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">{{ $category->deskripsi }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Gambar Kategori -->
            <div class="mb-6">
                <label for="image" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Gambar
                    Kategori</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('image')
                    <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
                @enderror
                @if ($category->image)
                    <img src="{{ asset('uploads/category/' . $category->image) }}" alt="Image"
                        class="mt-4 w-24 h-24 object-cover rounded">
                @endif
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        $(function(){
            $("#myFile").on("change", function(e) {
                const photoInput = $("#myFile");
                const file = this.files;
                if (file) {
                    $(".imgpreview img").attr("src", URL.createObjectURL(file));
                    $(".imgpreview").show();
                }
            });
        
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });
    
        function StringToSlug(text) {
            return text.toLowerCase()
                .replace(/[^\w]/g, '')
                .replace(/ +/g, "-");
        }
    </script>

</body>

</html>
