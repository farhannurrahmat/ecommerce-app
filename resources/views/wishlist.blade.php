@extends('layouts.app')

@section('content')
    <div class="container section-top">
        <h1>Your Wishlist</h1>
        @if ($wishlistItems->isEmpty())
            <p>Your wishlist is empty.</p>
        @else
            <div class="row">
                @foreach ($wishlistItems as $item)
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="{{ asset('uploads/products') }}/{{ $item->product->image1_url }}" class="card-img-top"
                                alt="{{ $item->product->product_name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->product->product_name }}</h5>
                                <p class="card-text">{{ $item->product->price }} IDR</p>
                                @if ($item->discount)
                                    <p>Discount: {{ $item->discount->discount_percentage }}%</p>
                                    <p>Discounted Price: {{ $item->discounted_price }}</p>
                                @endif
                                <div class="d-flex">
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Remove</button>
                                    </form>
                                    <form action="{{ route('wishlist.addToCart', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
