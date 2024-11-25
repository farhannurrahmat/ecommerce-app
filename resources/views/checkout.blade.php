@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>

<!-- Checkout Page -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Billing Details</h1>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-5">
                <!-- Informasi Pelanggan -->
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <h4>Customer Information</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-item w-100">
                        <label class="form-label my-3">Name<sup>*</sup></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $customer->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-item w-100">
                        <label class="form-label my-3">Email<sup>*</sup></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $customer->email ?? '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-item w-100">
                        <label class="form-label my-3">Phone<sup>*</sup></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $customer->phone ?? '') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-item w-100">
                        <label class="form-label my-3">Address Line 1<sup>*</sup></label>
                        <input type="text" name="address1" class="form-control @error('address1') is-invalid @enderror"
                            value="{{ old('address1', $customer->address1 ?? '') }}" required>
                        @error('address1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-item w-100">
                        <label class="form-label my-3">Address Line 2</label>
                        <input type="text" name="address2" class="form-control @error('address2') is-invalid @enderror"
                            value="{{ old('address2', $customer->address2 ?? '') }}">
                        @error('address2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-item w-100">
                        <label class="form-label my-3">Address Line 3</label>
                        <input type="text" name="address3" class="form-control @error('address3') is-invalid @enderror"
                            value="{{ old('address3', $customer->address3 ?? '') }}">
                        @error('address3')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="col-md-12 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ number_format($item->qty * $item->price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"><strong>Subtotal</strong></td>
                                            <td><strong>{{ Cart::instance('cart')->subtotal() }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Payment Options</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="paymentTransfer" name="payment_method" value="Transfer" required>
                                <label class="form-check-label" for="paymentTransfer">Direct Bank Transfer</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="paymentCOD" name="payment_method" value="COD">
                                <label class="form-check-label" for="paymentCOD">Cash On Delivery</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="paymentPaypal" name="payment_method" value="Paypal">
                                <label class="form-check-label" for="paymentPaypal">Paypal</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        Place Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            // Prevent double submission
            if (form.submitting) return false;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';
            form.submitting = true;

            // Continue with submission
            return true;
        });
    });
    </script>
@endpush

