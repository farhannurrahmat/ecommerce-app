@extends('layouts.app')
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite">
        <div class="container py-5">
            <h1 class="mb-4">Fresh fruits shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="fruits">Default Sorting:</label>
                                <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3"
                                    form="fruitform">
                                    <option value="volvo">Nothing</option>
                                    <option value="saab">Popularity</option>
                                    <option value="opel">Organic</option>
                                    <option value="audi">Fantastic</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#"><i
                                                                class="fas fa-apple-alt me-2"></i>{{ $category->category_name }}</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="{{ asset('template/img/banner-fruits.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4">
                                @foreach ($products as $product)
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="card h-100 shadow-sm border-0 rounded-3">
                                            <!-- Image Container with Fixed Aspect Ratio -->
                                            <div class="position-relative" style="padding-top: 100%;">
                                                <img src="{{ asset('uploads/products') }}/{{ $product->image1_url }}"
                                                    class="position-absolute top-0 start-0 w-100 h-100"
                                                    style="object-fit: cover;"
                                                    alt="{{ $product->product_name }}">

                                                <!-- Category Badge -->
                                                <span class="position-absolute badge bg-secondary"
                                                    style="top: 10px; left: 10px;">
                                                    {{ $product->category->category_name }}
                                                </span>

                                                <!-- Wishlist Button -->
                                                <div class="position-absolute" style="top: 10px; right: 10px;">
                                                    @if ($wishlistItems->contains('product_id', $product->id))
                                                        <form action="{{ route('wishlist.remove', $wishlistItems->where('product_id', $product->id)->first()->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger rounded-circle" title="Remove from wishlist">
                                                                <i class="bi bi-heart-fill"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('wishlist.add') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm" title="Add to wishlist">
                                                                <i class="bi bi-heart"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="card-body p-3">
                                                <!-- Product Name -->
                                                <h5 class="card-title mb-2 text-truncate">
                                                    <a href="{{ route('shop.product.details', $product->id) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $product->product_name }}
                                                    </a>
                                                </h5>

                                                <!-- Product Description -->
                                                <p class="card-text small text-muted mb-3"
                                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{ $product->description }}
                                                </p>

                                                <!-- Price Section -->
                                                <div class="mb-3">
                                                    @if ($product->discount && $product->discount->is_active)
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fs-5 fw-bold text-danger">
                                                                Rp{{ number_format($product->price - ($product->price * $product->discount->discount_percentage) / 100, 0, ',', '.') }}
                                                            </span>
                                                            <span class="badge bg-danger">
                                                                -{{ $product->discount->discount_percentage }}%
                                                            </span>
                                                        </div>
                                                        <div class="text-decoration-line-through text-muted small">
                                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                                        </div>
                                                    @else
                                                        <span class="fs-5 fw-bold">
                                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Cart Button -->
                                                @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                                                    <a href="{{ route('cart.index') }}"
                                                       class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-cart-check"></i>
                                                        <span>Go to Cart</span>
                                                    </a>
                                                @else
                                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                                        <button type="submit"
                                                                class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                                                            <i class="bi bi-cart-plus"></i>
                                                            <span>Add to Cart</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pagination -->
                                @if ($products->hasPages())
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $products->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection
