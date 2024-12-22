<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-sky-300 via-indigo-200 to-purple-300">
    <div class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4"
                role="alert">
                <strong class="font-bold">status!</strong>
                <span class="block sm:inline">{{ session('status') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3"
                    onclick="this.parentElement.remove();">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M14.348 5.652a.5.5 0 10-.707-.707L10 8.586 6.36 4.945a.5.5 0 00-.707.707L8.586 10l-3.333 3.333a.5.5 0 10.707.707L10 11.414l3.333 3.333a.5.5 0 10.707-.707L11.414 10l3.333-3.333z" />
                    </svg>
                </button>
            </div>
        @endif
        <!-- Order Summary -->
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-6 mb-6 transition-shadow duration-300 hover:shadow-lg">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Detail Pesanan</h2>
            <div class="space-y-3 text-gray-600 dark:text-gray-400">
                <p>ID Pesanan: <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->id }}</span></p>
                <p>Tanggal: <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->created_at }}</span>
                </p>
                <p>Delivered Date: <span
                        class="font-medium text-gray-800 dark:text-gray-100">{{ $order->delivered_date }}</span></p>
                <p>Canceled Date: <span
                        class="font-medium text-gray-800 dark:text-gray-100">{{ $order->canceled_date }}</span></p>
                <p>Status:
                    <span class="px-4 py-2 rounded-full bg-yellow-500 text-white font-semibold text-sm">
                        @if ($order->status == 'delivered')
                            <span class="bg-green-500">delivered</span>
                        @elseif ($order->status == 'canceled')
                            <span class="bg-red-500">canceled</span>
                        @else
                            <span>ordered</span>
                        @endif
                    </span>
                </p>
            </div>
        </div>

        <!-- Product List -->
        <div class="mb-6">
            <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Produk yang Dipesan</h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl hover:shadow-lg transition-shadow duration-300">
                <table class="w-full table-auto border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Produk</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Jumlah</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Subtotal</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Kategori</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Opsi</th>
                            <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 font-medium">Status
                                Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                        @foreach ($orderItem as $item)
                            <tr
                                class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-4 py-4 flex items-center text-gray-800 dark:text-gray-100">
                                    <img src="{{ asset('uploads/product/thumbnails') }}/{{ $item->product->image }}"
                                        alt="Product Image" class="w-14 h-14 rounded-lg mr-4">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-4 py-4 text-gray-800 dark:text-gray-100">{{ $item->quantity }}</td>
                                <td class="px-4 py-4 text-gray-800 dark:text-gray-100">{{ $item->price }}</td>
                                <td class="px-4 py-4 text-gray-800 dark:text-gray-100">
                                    {{ $item->product->category->name }}</td>
                                <td class="px-4 py-4 text-gray-800 dark:text-gray-100">{{ $item->options }}</td>
                                <td class="px-4 py-4 text-gray-800 dark:text-gray-100">
                                    {{ $item->rstatus == 0 ? 'No' : 'Yes' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Price Summary -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl transition-shadow duration-300 hover:shadow-lg">
                <p class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100">Subtotal:</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-200">{{ $order->subtotal }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl transition-shadow duration-300 hover:shadow-lg">
                <p class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100">Vat:</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-200">{{ $order->tax }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl transition-shadow duration-300 hover:shadow-lg">
                <p class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100">Harga:</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-200">{{ $order->total }}</p>
            </div>

            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl transition-shadow duration-300 hover:shadow-lg">
                <p class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100">Ongkos Kirim:</p>
                <p class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-200">Free</p>
            </div>
        </div>

        <!-- Payment Mode and Status -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Payment Mode -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl hover:shadow-lg transition-shadow duration-300">
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Payment Mode:</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-200">{{ $transaction->mode }}</p>
            </div>

            <!-- Status -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl hover:shadow-lg transition-shadow duration-300">
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Status:</p>
                <p class="text-lg font-semibold">
                    @if ($transaction->status == 'approved')
                        <span class="text-green-600">Approved</span>
                    @elseif ($transaction->status == 'declined')
                        <span class="text-red-600">Declined</span>
                    @elseif ($transaction->status == 'refunded')
                        <span class="text-yellow-600">Refunded</span>
                    @else
                        <span class="text-blue-600">Pending</span>
                    @endif
                </p>
            </div>

            <!-- Update Status -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl hover:shadow-lg transition-shadow duration-300">
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Update Status:</p>
                <form action="{{ route('admin.order.update_status') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('put')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div>
                        <label for="order_status" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Order Status:
                        </label>
                        <select id="order_status" name="order_status"
                            class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md py-2 px-3 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-300">
                            <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered
                            </option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled
                            </option>
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-300">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Shipping Information -->
        <div
            class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-2xl hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Informasi Pengiriman</h3>
            <div class="space-y-3 text-gray-600 dark:text-gray-400">
                <p>Nama Penerima: <span class="font-medium text-gray-800 dark:text-gray-100">{{ $order->name }}</span>
                </p>
                <p>Alamat:
                    <span class="font-medium text-gray-800 dark:text-gray-100">
                        {{ $order->address }}, {{ $order->city }}, {{ $order->state }}, {{ $order->locality }} -
                        {{ $order->zip }}
                    </span>
                </p>
            </div>
        </div>


        <!-- Back Button -->
        <div class="mt-6 text-center">
            <a href="javascript:history.back()"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">Kembali</a>
        </div>
    </div>
</body>

</html>
