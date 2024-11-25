<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // Ambil ID kategori dari request
        $categoryFilter = $request->query('categories');

        // Ambil produk berdasarkan filter kategori (jika ada)
        $query = Product::query();
        if ($categoryFilter) {
            $query->where('category_id', $categoryFilter);
        }
        $products = Product::with('discount') // Eager load relasi 'discount'
        ->orderBy('created_at', 'DESC')  // Urutkan berdasarkan created_at
        ->paginate(8);      


        // Wishlist (jika user login)
        $wishlistItems = auth()->check()
            ? Wishlist::where('customer_id', auth()->id())->get()
            : collect();

        return view('index', compact('products', 'categories', 'wishlistItems', 'categoryFilter'));
    }
}
