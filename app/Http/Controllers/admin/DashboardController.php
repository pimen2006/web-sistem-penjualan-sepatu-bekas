<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalCategories = \App\Models\Category::count();
        $totalProduct = \App\Models\Product::count();
        $totalOrder = \App\Models\Order::count();

        return view('admin.dashboard', compact('totalUsers', 'totalCategories', 'totalProduct', 'totalOrder'));
    }

    public function category(Request $request)
    {
        $query = Category::orderBy('id', 'DESC');

        // Cek jika ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(10);

        return view('admin.category', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->deskripsi = $request->deskripsi;
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbnailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.category')->with('status', 'category berasil ditambahkan');
    }

    public function GenerateCategoryThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/category');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->deskripsi = $request->deskripsi;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/category') . '/' . $category->image)) {
                File::delete(public_path('uploads/category') . '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbnailsImage($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.category')->with('status', 'category telah di update');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/category') . '/' . $category->image)) {
            File::delete(public_path('uploads/category') . '/' . $category->image);
        }

        $category->delete();
        return redirect()->route('admin.category')->with('status', 'Category berasil di hapus');
    }

    public function products(Request $request)
    {
        $query = Product::orderBy('created_at', 'DESC');

        // Jika ada pencarian berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured === 'yes' ? 1 : 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtion = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . "-" . $counter . "-" . $gextension;
                    $this->GenerateProductThumbnailsImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }

        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product berasil di tambahkan');
    }

    public function GenerateProductThumbnailsImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/product/thumbnails');
        $destinationPath = public_path('uploads/product');
        $img = Image::read($image->path());
        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }

    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured === 'yes' ? 1 : 0;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {

            if (File::exists(public_path('uploads/product') . '/' . $product->image)) {
                File::delete(public_path('uploads/product') . '/' . $product->image);
            }
            if (File::exists(public_path('uploads/product/thumbnails') . '/' . $product->image)) {
                File::delete(public_path('uploads/product/thumbnails') . '/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {

            foreach (explode(',', $product->images) as $ofile) {
                if (File::exists(public_path('uploads/product') . '/' . $ofile)) {
                    File::delete(public_path('uploads/product') . '/' . $ofile);
                }
                if (File::exists(public_path('uploads/product/thumbnails') . '/' . $ofile)) {
                    File::delete(public_path('uploads/product/thumbnails') . '/' . $ofile);
                }
            }

            $allowedfileExtion = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . "-" . $counter . "-" . $gextension;
                    $this->GenerateProductThumbnailsImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }

        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'product berasil diupdate');
    }

    public function product_delete($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('uploads/product') . '/' . $product->image)) {
            File::delete(public_path('uploads/product') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/product/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/product/thumbnails') . '/' . $product->image);
        }

        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/product') . '/' . $ofile)) {
                File::delete(public_path('uploads/product') . '/' . $ofile);
            }
            if (File::exists(public_path('uploads/product/thumbnails') . '/' . $ofile)) {
                File::delete(public_path('uploads/product/thumbnails') . '/' . $ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'product berasil dihapus');
    }

    public function order(Request $request)
    {
        $query = Order::orderBy('created_at', 'DESC');

        // Pencarian berdasarkan nama di tabel orders
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $orders = $query->paginate(10);

        return view('admin.order', compact('orders'));
    }


    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItem = OrderItem::where('order_id', $order_id)->orderBy('id')->get();
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order_detail', compact('order', 'orderItem', 'transaction'));
    }

    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }

        return back()->with("status", "status berasil diganti");
    }

    public function customers(Request $request)
    {
        $query = User::query();

        // Search by name or role
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('role', 'like', "%$search%");
            });
        }

        // Paginate results
        $users = $query->paginate(10);

        return view('admin.customers', compact('users'));
    }


    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',  // Validasi role yang boleh dipilih
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();  // Simpan perubahan

        return redirect()->route('admin.customers')->with('status', 'Role user telah diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Delete user
        $user->delete();

        return redirect()->route('admin.customers')->with('status', 'User deleted successfully');
    }
}
