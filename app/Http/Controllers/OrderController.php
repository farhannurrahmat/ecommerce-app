<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik customer yang sedang login
        $orders = Order::where('customer_id', Auth::guard('customer')->id())->get();

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    public function show($id)
    {
        // Ambil detail pesanan berdasarkan ID
        $order = Order::with('orderItems.product')->findOrFail($id);

        return view('orders.show', [
            'order' => $order
        ]);
    }
}

