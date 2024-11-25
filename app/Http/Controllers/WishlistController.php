<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function index()
    {
        // Ambil data wishlist milik user yang sedang login
        $wishlistItems = Wishlist::with('product')
            ->where('customer_id', Auth::id())
            ->get();

        return view('wishlist', compact('wishlistItems'));
    }

    public function addToWishlist(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);

            // Cek apakah produk sudah ada di wishlist user
            $exists = Wishlist::where('customer_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('info', 'Product already in your wishlist.');
            }

            // Simpan ke database
            Wishlist::create([
                'customer_id' => Auth::id(),
                'product_id' => $product->id,
            ]);

            return redirect()->back()->with('success', 'Product added to wishlist successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product to wishlist.');
        }
    }

    public function removeFromWishlist($id)
    {
        try {
            $wishlist = Wishlist::where('customer_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $wishlist->delete();

            return redirect()->back()->with('success', 'Product removed from wishlist!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove product from wishlist.');
        }
    }

    public function addToCart($id)
    {
        $wishlist = Wishlist::with('product')->find($id);

        // Validasi jika item tidak ditemukan
        if (!$wishlist || $wishlist->customer_id != Auth::id()) {
            return redirect()->back()->with('error', 'Item not found in wishlist.');
        }

        $product = $wishlist->product;

        // Tambahkan ke cart menggunakan package Shoppingcart
        Cart::instance('cart')->add([
            'id'      => $product->id,
            'name'    => $product->product_name,
            'qty'     => 1, // Default jumlah
            'price'   => $product->price,
            'options' => [
                'image' => $product->image1_url,
            ],
        ]);
        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully!');
    }
}
