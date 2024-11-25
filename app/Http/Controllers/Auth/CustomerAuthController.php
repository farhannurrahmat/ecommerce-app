<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            Auth::guard('customer')->login($customer);

            // Cek apakah login berhasil
            return redirect()->route('shop.index');
        }

        return back()->withErrors(['email' => 'The provided credentials are incorrect.']);
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }

    public function showRegistrationForm()
{
    return view('auth.customer-register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:customers',
        'password' => 'required|string|min:8|confirmed',
        'phone' => 'required|string|max:15',
        'address1' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',
        'address3' => 'nullable|string|max:255',
    ]);

    $customer = Customer::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'address1' => $request->address1,
        'address2' => $request->address2,
        'address3' => $request->address3,
    ]);

    Auth::guard('customer')->login($customer);

    return redirect()->route('shop.index');
}
}
