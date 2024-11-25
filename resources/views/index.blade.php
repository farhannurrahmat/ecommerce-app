@extends('layouts.app')
@section('content')
    <main>

        <!-- Hero Start -->
        <div class="container-fluid mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                        <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number"
                                placeholder="Search">
                            <button type="submit"
                                class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 25%;">Submit Now</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="{{ asset('template/img/hero-img-1.png') }}"
                                        class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Fruits</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{ asset('template/img/hero-img-2.jpg') }}"
                                        class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Vegetables</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

                <!-- Featurs Start -->
                <div class="container-fluid service py-5">
                    <div class="container py-5">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-6 col-lg-4">
                                <a href="#">
                                    <div class="service-item bg-secondary rounded border border-secondary">
                                        <img src="{{ asset('template/img/featur-1.jpg') }}" class="img-fluid rounded-top w-100"
                                            alt="">
                                        <div class="px-4 rounded-bottom">
                                            <div class="service-content bg-primary text-center p-4 rounded">
                                                <h5 class="text-white">Fresh Apples</h5>
                                                <h3 class="mb-0">20% OFF</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <a href="#">
                                    <div class="service-item bg-dark rounded border border-dark">
                                        <img src="{{ asset('template/img/featur-2.jpg') }}" class="img-fluid rounded-top w-100"
                                            alt="">
                                        <div class="px-4 rounded-bottom">
                                            <div class="service-content bg-light text-center p-4 rounded">
                                                <h5 class="text-primary">Tasty Fruits</h5>
                                                <h3 class="mb-0">Free delivery</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <a href="#">
                                    <div class="service-item bg-primary rounded border border-primary">
                                        <img src="{{ asset('template/img/featur-3.jpg') }}" class="img-fluid rounded-top w-100"
                                            alt="">
                                        <div class="px-4 rounded-bottom">
                                            <div class="service-content bg-secondary text-center p-4 rounded">
                                                <h5 class="text-white">Exotic Vegetable</h5>
                                                <h3 class="mb-0">Discount 30$</h3>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featurs End -->

        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <!-- Filter Kategori -->
                        <div class="col-lg-4 text-start">
                            <h1>Our Organic Products</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex m-2 py-2 bg-light rounded-pill active {{ !request('categories') ? 'active' : '' }}"
                                        href="#all-products" data-bs-toggle="tab" role="tab"
                                        aria-controls="all-products"
                                        aria-selected="{{ !request('categories') ? 'true' : 'false' }}">All Products</a>
                                </li>
                                @foreach ($categories as $category)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex m-2 py-2 bg-light rounded-pill {{ request('categories') == $category->id ? 'active' : '' }}"
                                            href="#category-{{ $category->id }}" data-bs-toggle="tab" role="tab"
                                            aria-controls="category-{{ $category->id }}"
                                            aria-selected="{{ request('categories') == $category->id ? 'true' : 'false' }}">{{ $category->category_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Daftar Produk -->
                    <div class="tab-content">
                        <div class="tab-pane fade {{ !request('categories') ? 'show active' : '' }}" id="all-products"
                            role="tabpanel">
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

                        @foreach ($categories as $category)
                            <div class="tab-pane fade {{ request('categories') == $category->id ? 'show active' : '' }}"
                                id="category-{{ $category->id }}" role="tabpanel">
                                <div class="row g-4">
                                    @foreach ($products->where('category_id', $category->id) as $product)
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
                                                        @if (Auth::check() && $wishlistItems->contains('product_id', $product->id))
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
                                                        {{ \Illuminate\Support\Str::limit($product->description, 30) }}
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
                                                                <div class="text-decoration-line-through text-muted small">
                                                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                                                </div>
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

                                    <!-- Pagination with Category Filter -->
                                    @if ($products->hasPages())
                                        <div class="col-12">
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $products->appends(['categories' => $categoryFilter])->links('pagination::bootstrap-5') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Fruits Shop End-->

        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Fresh Exotic Fruits</h1>
                            <p class="fw-normal display-3 text-dark mb-4">in Our Store</p>
                            <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition
                                injected humour, or non-characteristic words etc.</p>
                            <a href="#"
                                class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="{{ asset('template/img/baner-1.png') }}" class="img-fluid w-100 rounded"
                                alt="">
                            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute"
                                style="width: 140px; height: 140px; top: 0; left: 0;">
                                <h1 style="font-size: 100px;">1</h1>
                                <div class="d-flex flex-column">
                                    <span class="h2 mb-0">50$</span>
                                    <span class="h4 text-muted mb-0">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->


        <!-- Tastimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="testimonial-header text-center">
                    <h4 class="text-primary">Our Testimonial</h4>
                    <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                    industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('template/img/testimonial-1.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                    industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('template/img/testimonial-1.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the
                                    industry's standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('template/img/testimonial-1.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tastimonial End -->
    </main>
@endsection

@push('scripts')
    <script>
        function filterByCategory(categoryId) {
            // Set value pada hidden input
            document.getElementById('hdnCategories').value = categoryId;

            // Aktifkan tab pane yang sesuai
            const tabPane = document.querySelector(`#category-${categoryId}`);
            if (tabPane) {
                const tab = new bootstrap.Tab(tabPane);
                tab.show();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeCategory = urlParams.get('categories');

            if (activeCategory) {
                filterByCategory(activeCategory);
            }
        });
    </script>
@endpush
