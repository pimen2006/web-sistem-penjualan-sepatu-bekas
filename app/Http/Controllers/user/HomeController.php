<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class HomeController extends Controller
{
    public function index()
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        // Ambil produk dengan featured = 1
        $products = Product::where('featured', true)
            ->where('featured', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $categories = Category::all();

        return view('user.home', compact('cartCount', 'categories', 'products'));
    }


    public function show()
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        return view('user.profil', compact('cartCount'));
    }

    // Menampilkan halaman edit profil
    public function edit()
    {
        return view('user.edit_profil');
    }

    // Memperbarui data profil
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);

            // Delete old profile picture if exists
            if ($user->profile_picture) {
                $oldPath = public_path('uploads/user/' . $user->profile_picture);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $user->profile_picture = $filename;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
