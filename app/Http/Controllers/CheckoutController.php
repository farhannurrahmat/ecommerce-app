<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Delivery;
use App\Models\Payment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    public function index()
    {
        $customer = auth('customer')->user();
        // Gunakan instance 'cart' yang sama
        $cartItems = Cart::instance('cart')->content();
        $cartTotal = Cart::instance('cart')->total();

        if (!$customer) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('checkout', [
            'customer' => $customer,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ]);
    }

    public function store(Request $request)
    {
        // Enable query log for debugging
        DB::enableQueryLog();

        Log::info('Checkout Started', ['request' => $request->all()]);

        try {
            // 1. Basic validation
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required',
                'address1' => 'required',
                'payment_method' => 'required|in:Transfer,COD,Paypal'
            ]);

            // 2. Get authenticated customer
            $customer = Auth::guard('customer')->user();
            if (!$customer) {
                throw new \Exception('Customer not authenticated');
            }

            // 3. Check if cart is empty
            if (Cart::instance('cart')->count() == 0) {
                throw new \Exception('Cart is empty');
            }

            DB::beginTransaction();

            // 4. Update customer details
            Customer::where('id', $customer->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
            ]);

            // 5. Calculate total (remove formatting)
            $rawTotal = Cart::instance('cart')->total();
            $totalAmount = (float) str_replace([',', '.'], '', $rawTotal);

            // 6. Create order
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->order_date = now();
            $order->total_amount = $totalAmount;
            $order->status = 'success';
            $order->save();

            Log::info('Order created', ['order_id' => $order->id]);

            // 7. Create order details
            foreach (Cart::instance('cart')->content() as $item) {
                $product = Product::find($item->id);

                if (!$product) {
                    throw new \Exception("Product not found: {$item->id}");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'subtotal' => $item->price * $item->qty
                ]);

                // Update stock if needed
                // $product->decrement('stock', $item->qty);
            }

            // 8. Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_date' => now(),
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount
            ]);

            // 9. Create delivery record
            Delivery::create([
                'order_id' => $order->id,
                'shipping_date' => now(),
                'tracking_code' => 'TRK-' . strtoupper(uniqid()),
                'status' => 'success'
            ]);

            // 10. Clear cart and commit transaction
            Cart::instance('cart')->destroy();
            DB::commit();

            Log::info('Checkout completed successfully', [
                'order_id' => $order->id,
                'queries' => DB::getQueryLog()
            ]);

            return redirect()->route('checkout.success')
                ->with('success', 'Order berhasil dibuat!')
                ->with('order_id', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'queries' => DB::getQueryLog()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function success()
    {
        // If there's no order in session, redirect to home
        if (!session()->has('order_id')) {
            return redirect()->route('home.index');
        }

        $order = Order::with(['payment', 'delivery'])
            ->where('id', session('order_id'))
            ->where('customer_id', auth('customer')->id())
            ->firstOrFail();

        return view('checkout_success', [
            'order' => $order,
            'payment_method' => $order->payment->payment_method ?? session('payment_method')
        ]);
    }
}
