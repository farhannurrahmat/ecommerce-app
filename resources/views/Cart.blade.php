@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5 vh-100">
        <div class="container py-5">
            @if (Cart::instance('cart')->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Products</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::instance('cart')->content() as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/products/thumbnails/' . $item->options->image) }}"
                                                class="img-fluid me-3 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="{{ $item->name }}">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-3">{{ $item->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-dark fs-5 fw-bold mb-0">
                                            @if ($item->discount && $item->discount->is_active)
                                                <span class="text-decoration-line-through text-muted">
                                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                                </span>
                                                <span class="text-danger ms-2">
                                                    {{ $item->discount->discount_percentage }}%
                                                </span>
                                                <br>
                                                <span class="text-success">
                                                    Rp{{ number_format($item->price - ($item->price * $item->discount->discount_percentage) / 100, 0, ',', '.') }}
                                                </span>
                                            @else
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex  mt-3">
                                            <form action="{{ route('cart.update', $item->rowId) }}" method="POST"
                                                class="mr-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->qty - 1 }}">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                            <input type="number" name="quantity" value="{{ $item->qty }}"
                                                class="form-control form-control-sm text-center border-0" min="1"
                                                style="width: 50px;">
                                            <form action="{{ route('cart.update', $item->rowId) }}" method="POST"
                                                class="ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->qty + 1 }}">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-3">Rp{{ number_format($item->subtotal, 2) }}</p>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-md rounded-circle bg-light border mt-3">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h4 class="mb-3">Cart Totals</h4>
                    <p>Subtotal: <strong>Rp{{ Cart::instance('cart')->subtotal() }}</strong></p>
                    <p>Tax: <strong>0</strong></p>
                    {{-- <p>Total: <strong>${{ Cart::instance('cart')->total() }}</strong></p> --}}
                    <p>Subtotal: <strong>Rp{{ Cart::instance('cart')->subtotal() }}</strong></p>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            @else
                <div class="text-center py-5">
                    <p>Your cart is empty</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
                </div>
            @endif
        </div>
    </div>
@endsection
