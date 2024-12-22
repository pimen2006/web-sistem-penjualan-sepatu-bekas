<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    public function index($category_id)
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        // Jika category_id 0, ambil semua produk dengan stok tersedia
        if ($category_id == 0) {
            $products = Product::where('quantity', '>', 0)->get(); // Produk hanya dengan stok > 0
            $category = null; // Tidak ada kategori yang dipilih
        } else {
            // Ambil kategori berdasarkan ID
            $category = Category::findOrFail($category_id);

            // Ambil produk berdasarkan kategori dengan stok tersedia
            $products = Product::where('category_id', $category_id)
                ->where('quantity', '>', 0)
                ->get();
        }

        return view('user.shop', compact('category', 'products', 'cartCount'));
    }


    public function search(Request $request, $category_id)
    {
        $searchText = $request->input('search');

        // Ambil kategori berdasarkan ID
        $category = Category::find($category_id);

        // Jika kategori tidak ditemukan, arahkan ke home
        if (!$category) {
            return redirect()->route('home')->with('error', 'Category not found');
        }

        // Cari produk dengan nama sesuai pencarian dan stok tersedia
        $products = Product::where('category_id', $category_id)
            ->where('name', 'LIKE', '%' . $searchText . '%')
            ->where('quantity', '>', 0) // Produk hanya dengan stok > 0
            ->get();

        return view('user.shop', compact('products', 'category', 'searchText'));
    }


    public function product_details($product_slug)
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        // Ambil produk utama berdasarkan slug
        $product = Product::where('slug', $product_slug)->first();

        // Ambil produk terkait dengan stok tersedia
        $products = Product::where('slug', '<>', $product_slug)
            ->where('quantity', '>', 0) // Produk hanya dengan stok > 0
            ->take(8)
            ->get();

        return view('user.detail_product', compact('product', 'products', 'cartCount'));
    }
}
