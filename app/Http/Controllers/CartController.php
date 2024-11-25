<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('cart')->content();
        $products = Product::with('discount')->get();
        return view('cart', compact('cartItems', 'products'));
    }

    public function __construct()
    {
        // Pastikan semua method di controller ini perlu login customer
        $this->middleware('auth:customer');
    }
    public function addToCart(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);

            Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->product_name,
                'qty' => $request->quantity,
                'price' => $product->price,
                'weight' => 0,
                'options' => [
                    'image' => $product->image1_url
                ]
            ]);

            session()->flash('success', 'Product added to cart successfully!');
            return redirect()->route('cart.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add product to cart.');
            return redirect()->back();
        }

    }
    public function remove($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        session()->flash('success', 'Item has been removed from cart!');
        return redirect()->route('cart.index');
    }

    public function update(Request $request, $rowId)
    {
        Cart::instance('cart')->update($rowId, $request->quantity);
        session()->flash('success', 'Cart updated successfully!');
        return redirect()->route('cart.index');
    }
}
