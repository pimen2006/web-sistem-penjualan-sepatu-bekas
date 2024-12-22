<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Produk</h1>

        <form class="bg-white p-8 rounded-lg shadow-lg space-y-6" action="{{ route('admin.product-store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Nama Produk -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="name" value="{{ old('name') }}" required>
            </div>
            @error('name')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Slug -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Slug</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="slug" value="{{ old('slug') }}" required>
            </div>
            @error('slug')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Kategori -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="category_id" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_id')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Short Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Short Deskripsi</label>
                <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"
                    name="short_description" required>{{ old('short_description') }}</textarea>
            </div>
            @error('short_description')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="5"
                    name="description" required>{{ old('description') }}</textarea>
            </div>
            @error('description')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Upload Image -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar</label>
                <input type="file" id="myFile" class="w-full px-4 py-2 border rounded-lg" name="image"
                    accept="image/*" required>
            </div>
            @error('image')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Upload Gallery Image -->
            <div id="galUpload">
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar Galeri</label>
                <input type="file" id="gfile" class="w-full px-4 py-2 border rounded-lg" name="images[]"
                    accept="image/*" multiple>
            </div>
            @error('gimages')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Regular Price -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Reguler</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="regular_price" value="{{ old('regular_price') }}" required>
            </div>
            @error('regular_price')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Sale Price -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Diskon</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="sale_price" value="{{ old('sale_price') }}">
            </div>
            @error('sale_price')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- SKU -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">SKU</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="SKU" value="{{ old('SKU') }}" required>
            </div>
            @error('SKU')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Quantity -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kuantitas</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="quantity" value="{{ old('quantity') }}" required>
            </div>
            @error('quantity')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Stock Status -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status Stok</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="stock_status" required>
                    <option value="instock">Tersedia</option>
                    <option value="outofstock">Habis</option>
                </select>
            </div>
            @error('stock_status')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Featured -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Unggulan</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="featured">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            @error('featured')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">Simpan
                    Produk</button>
            </div>
        </form>
    </div>
</body>

<script>
    $(function(){
        $("#myFile").on("change", function(e) {
            const photoInput = $("#myFile");
            const [file] = this.files;
            if (file) {
                $(".imgpreview img").attr("src", URL.createObjectURL(file));
                $(".imgpreview").show();
            }
        });

        $("#gFile").on("change", function(e) {
            const photoInput = $("#gFile");
            const gphotos = this.files;
            $.each(gphotos, function(key,val){
                $("#galUpload").prepend(`<div class="gap-4"><img src="${URL.createObjectURL(val)}"/></div>`);
            });
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

</html>
