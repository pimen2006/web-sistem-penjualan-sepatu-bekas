<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // Mendapatkan cart yang unik berdasarkan email pengguna
    protected function getCartInstance()
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        return Cart::instance('cart_' . $userEmail); // Instance cart unik untuk setiap email pengguna
    }

    public function index()
    {
        $cart = $this->getCartInstance(); // Mengambil cart unik berdasarkan email pengguna
        $items = $cart->content();
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        return view('user.cart', compact('items', 'cartCount'));
    }

    public function add_cart(Request $request)
    {
        $cart = $this->getCartInstance(); // Mengambil cart unik berdasarkan email pengguna
        $cart->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate('App\Models\Product'); // Mengasosiasikan produk dengan model
        return redirect()->back();
    }

    public function increase_quantity($rowId)
    {
        $cart = $this->getCartInstance();
        $product = $cart->get($rowId); // Ambil produk dari keranjang

        // Ambil produk dari database untuk mendapatkan stok terbaru
        $dbProduct = \App\Models\Product::find($product->id);

        // Jika produk tidak ditemukan di database
        if (!$dbProduct) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Menghitung total kuantitas setelah penambahan
        $newQty = $product->qty + 1;

        // Periksa apakah stok cukup menggunakan quantity dari database
        if ($newQty > $dbProduct->quantity) { // Menggunakan $dbProduct->quantity
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $dbProduct->quantity);
        }

        // Jika stok mencukupi, update kuantitas produk di keranjang
        $cart->update($rowId, $newQty);

        return redirect()->back()->with('success', 'Kuantitas produk berhasil ditingkatkan.');
    }


    public function decrease_quantity($rowId)
    {
        $cart = $this->getCartInstance();
        $product = $cart->get($rowId);

        // Periksa apakah produk ditemukan di keranjang
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        // Ambil produk dari database untuk mendapatkan stok terbaru
        $dbProduct = \App\Models\Product::find($product->id);

        // Jika produk tidak ditemukan di database
        if (!$dbProduct) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Jika kuantitas menjadi 0, hapus item dari keranjang
        if ($product->qty - 1 <= 0) {
            $cart->remove($rowId); // Hapus item dari keranjang
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        // Periksa jika pengurangan kuantitas di keranjang melebihi stok produk yang tersedia
        if ($product->qty - 1 > $dbProduct->quantity) {
            return redirect()->back()->with('error', 'Kuantitas di keranjang melebihi stok produk yang tersedia. Stok tersedia: ' . $dbProduct->quantity);
        }

        // Jika tidak, kurangi kuantitas produk di keranjang
        $cart->update($rowId, $product->qty - 1);

        return redirect()->back()->with('success', 'Kuantitas produk berhasil dikurangi.');
    }


    public function remove_item($rowId)
    {
        $cart = $this->getCartInstance(); // Mengambil cart unik berdasarkan email pengguna
        $cart->remove($rowId); // Menghapus produk dari cart
        return redirect()->back();
    }

    public function checkout()
    {
        // Mendapatkan instance cart pengguna
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Membuat cart unik untuk setiap pengguna

        $items = $cart->content(); // Mengambil semua item di keranjang
        $taxTotal = 0;

        // Hitung pajak untuk setiap item di keranjang
        foreach ($items as $item) {
            $itemSubtotal = (float) str_replace([','], '', $item->price) * $item->qty; // Harga per item x kuantitas
            $itemTax = $itemSubtotal * 0.05; // Pajak 5%
            $taxTotal += $itemTax; // Total pajak keseluruhan
        }

        // Hitung subtotal dan total termasuk pajak
        $subtotal = (float) str_replace([','], '', $cart->subtotal()); // Subtotal tanpa pajak
        $total = $subtotal + $taxTotal; // Total termasuk pajak

        // Ambil jumlah produk unik dalam keranjang
        $cartCount = $cart->content()->count();

        // Mendapatkan alamat pengguna yang default
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();

        // Mengirim data ke tampilan
        return view('user.order', compact('address', 'cartCount', 'items', 'subtotal', 'taxTotal', 'total'));
    }


    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            // Validasi dan simpan alamat baru jika tidak ada alamat default
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric',
                'zip' => 'required|numeric',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }

        // Hitung subtotal, pajak, dan total
        $cart = $this->getCartInstance();
        $subtotal = $cart->subtotal();
        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax;

        // Simpan data checkout ke sesi
        Session::put('checkout', [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        // Ambil data checkout dari sesi
        $checkout = Session::get('checkout');

        // Pastikan sesi checkout ada
        if (!$checkout) {
            return redirect()->back()->with('error', 'Checkout tidak valid. Silakan coba lagi.');
        }

        // Simpan data pesanan ke tabel orders
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $checkout['subtotal'];
        $order->tax = $checkout['tax'];
        $order->total = $checkout['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        // Simpan detail pesanan dan kurangi stok produk
        foreach ($cart->content() as $item) {
            // Simpan detail pesanan
            $orderitem = new OrderItem();
            $orderitem->product_id = $item->id;
            $orderitem->order_id = $order->id;
            $orderitem->price = $item->price;
            $orderitem->quantity = $item->qty;
            $orderitem->save();

            // Kurangi stok produk
            $product = \App\Models\Product::find($item->id);
            if ($product) {
                $product->quantity -= $item->qty; // Kurangi stok sesuai kuantitas yang dipesan
                $product->save();
            }
        }

        // Simpan transaksi (jika menggunakan COD)
        if ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }

        // Kosongkan cart dan simpan order_id di session
        $cart->destroy();
        Session::forget('checkout');
        Session::put('order_id', $order->id);

        return redirect()->route('orders'); // Redirect ke halaman daftar pesanan
    }

    // Menampilkan form untuk edit alamat
    public function editAddress()
    {
        // Mendapatkan alamat default pengguna
        $address = Address::where('user_id', Auth::user()->id)
            ->where('isdefault', true)
            ->first();

        if (!$address) {
            return redirect()->route('cart.checkout')->with('error', 'Alamat pengirim tidak ditemukan.');
        }

        // Mendapatkan jumlah produk di keranjang
        $userEmail = Auth::user()->email;
        $cart = Cart::instance('cart_' . $userEmail);
        $cartCount = $cart->content()->count();

        return view('user.edit_alamat', compact('address', 'cartCount'));
    }

    // Mengupdate alamat pengirim
    public function updateAddress(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric',
            'zip' => 'required|numeric',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
        ]);

        // Mendapatkan alamat default pengguna
        $address = Address::where('user_id', Auth::user()->id)
            ->where('isdefault', true)
            ->first();

        if (!$address) {
            return redirect()->route('checkout')->with('error', 'Alamat pengirim tidak ditemukan.');
        }

        // Memperbarui data alamat pengirim
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->save();

        // Redirect ke halaman checkout atau halaman lainnya
        return redirect()->route('checkout')->with('success', 'Alamat pengirim berhasil diperbarui.');
    }

    public function orders()
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart

        $user_id = Auth::user()->id;

        // Ambil semua pesanan pengguna dengan detail produk
        $orders = Order::where('user_id', $user_id)
            ->with('orderItems.product') // Mengambil detail produk melalui relasi
            ->get();

        return view('user.pesanan', compact('orders', 'cartCount'));
    }

    public function order_detail($order_id)
    {
        $userEmail = Auth::user()->email; // Mendapatkan email pengguna yang sedang login
        $cart = Cart::instance('cart_' . $userEmail); // Cart unik untuk setiap pengguna
        $cartCount = $cart->content()->count(); // Mengambil jumlah produk unik di cart
        
        $order = Order::where('user_id', Auth::user()->id)->where('id',$order_id)->first();
        if($order){
            $orderItem = OrderItem::where('order_id',$order->id)->orderBy('id')->get();
            $transaction = Transaction::where('order_id',$order->id)->first();
            return view('user.detail_order', compact('order', 'cartCount', 'orderItem', 'transaction'));
        } else {
            return redirect()->route('home');
        }
    }

    public function order_cancel(Request $request){
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->save();
        return back()->with('status','order berasil dicancel');
    }
}
