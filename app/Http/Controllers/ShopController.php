<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('discount') // Eager load relasi 'discount'
            ->orderBy('created_at', 'DESC')  // Urutkan berdasarkan created_at
            ->paginate(12);
        $categories = Category::orderBy('created_at', 'DESC')->get();
        $wishlistItems = auth()->check()
            ? Wishlist::where('customer_id', auth()->id())->get() // Mengambil wishlist berdasarkan user yang login
            : collect();
        return view('shop', compact('products', 'categories', 'wishlistItems'));
    }

    public function product_details($id)
    {
        $product = Product::findOrFail($id);
        return view('details', compact('product'));
    }
}
