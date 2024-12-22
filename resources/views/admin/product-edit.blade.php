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
        <h1 class="text-3xl font-bold text-gray-800 mb-6">edit Produk</h1>

        <form class="bg-white p-8 rounded-lg shadow-lg space-y-6" action="{{ route('admin.product-update') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Nama Produk -->
            <input type="hidden" name="id" value="{{ $product->id }}" />
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="name" value="{{ $product->name }}" required>
            </div>
            @error('name')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Slug -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Slug</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="slug" value="{{ $product->slug }}" required>
            </div>
            @error('slug')
                <span class="text-red-600
                    text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Kategori -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="category_id" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
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
                    name="short_description" required>{{ $product->short_description }}</textarea>
            </div>
            @error('short_description')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Deskripsi -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="5"
                    name="description" required>{{ $product->description }}</textarea>
            </div>
            @error('description')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Upload Image -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar</label>
                <input type="file" id="myFile" class="w-full px-4 py-2 border rounded-lg" name="image"
                    accept="image/*">
                @if ($product->image)
                    <img src="{{ asset('uploads/product') }}/{{ $product->image }}" alt="{{ $product->name }}"
                        class="mt-4 w-24 h-24 object-cover rounded">
                @endif
            </div>
            @error('image')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Upload Gallery Image -->
            <div id="galUpload">
                <label class="block text-gray-700 font-semibold mb-2">Upload Gambar Galeri</label>
                <input type="file" id="gfile" class="w-full px-4 py-2 border rounded-lg" name="images[]"
                    accept="image/*" multiple>
                @if ($product->images)
                    @foreach (explode(',', $product->images) as $img)
                        <div class="item gitems">
                            <img src="{{ asset('uploads/product') }}/{{ trim($img) }}" alt="{{ $product->name }}"
                                class="mt-4 w-24 h-24 object-cover rounded">
                        </div>
                    @endforeach
                @endif
            </div>
            @error('gimages')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Regular Price -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Reguler</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="regular_price" value="{{ $product->regular_price }}" required>
            </div>
            @error('regular_price')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Sale Price -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Harga Diskon</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="sale_price" value="{{ $product->sale_price }}">
            </div>
            @error('sale_price')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- SKU -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">SKU</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="SKU" value="{{ $product->SKU }}" required>
            </div>
            @error('SKU')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Quantity -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kuantitas</label>
                <input type="text"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="quantity" value="{{ $product->quantity }}" required>
            </div>
            @error('quantity')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Stock Status -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Status Stok</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="stock_status" required>
                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>Tersedia
                    </option>
                    <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Habis
                    </option>
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
                    <option value="yes" {{ $product->featured == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ $product->featured == 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            @error('featured')
                <span class="text-red-600 text-sm font-medium mt-1 block">{{ $message }}</span>
            @enderror
            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">Update
                    Produk</button>
            </div>
        </form>
    </div>
</body>

<script>
    $(function() {
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
            $.each(gphotos, function(key, val) {
                $("#galUpload").prepend(
                    `<div class="gap-4"><img src="${URL.createObjectURL(val)}"/></div>`);
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
