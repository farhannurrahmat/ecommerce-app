@extends('layouts.app')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Order Successful</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
        <li class="breadcrumb-item active text-white">Order Success</li>
    </ol>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                    </div>

                    <h2 class="card-title mb-4">Thank You for Your Order!</h2>

                    @if(session('order_id'))
                        <p class="lead mb-3">Your order #{{ session('order_id') }} has been placed successfully.</p>
                    @endif

                    <div class="alert alert-info mx-auto" style="max-width: 500px;">
                        <p class="mb-0">We have sent an order confirmation email with order details and tracking information.</p>
                    </div>

                    <div class="order-details mt-4">
                        <h4 class="mb-3">What's Next?</h4>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-money-check-alt me-2"></i>Payment Status
                                        </h5>
                                        @if(session('payment_method') == 'Transfer')
                                            <p class="card-text">Please complete your payment by transferring to our bank account:</p>
                                            <div class="alert alert-secondary">
                                                <strong>Bank Account Details:</strong><br>
                                                Bank Name: YOUR BANK<br>
                                                Account Number: YOUR ACCOUNT NUMBER<br>
                                                Account Name: YOUR COMPANY NAME
                                            </div>
                                        @elseif(session('payment_method') == 'COD')
                                            <p class="card-text">Payment will be collected upon delivery.</p>
                                        @else
                                            <p class="card-text">Your payment has been processed through {{ session('payment_method') }}.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        {{-- <a href="{{ route('orders.index') }}" class="btn btn-primary me-3">
                            <i class="fas fa-list-ul me-2"></i>View My Orders
                        </a> --}}
                        <a href="{{ route('home.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
