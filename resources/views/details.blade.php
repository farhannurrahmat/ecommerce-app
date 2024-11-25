@extends('layouts.app')
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Shop Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset('uploads/products/' . $product->image1_url) }}"
                                        class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $product->product_name }}</h4>
                            <p class="mb-3">{{ $product->category->category_name }}</p>
                            <h5 class="fw-bold mb-3">{{ $product->price }}</h5>
                            <div class="d-flex mb-4">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star {{ $i < $product->rating ? 'text-secondary' : '' }}"></i>
                                @endfor
                            </div>
                            <p class="mb-4">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            @if (Cart::instance('cart')->content()->Where('id', $product->id)->count() > 0)
                                <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3">Go to Cart</a>
                            @else
                                <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <div class="product-single__addtocart">
                                        <div class="input-group quantity mb-5" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="number" class="form-control form-control-sm text-center border-0"
                                                vname="quantity" value="1" min="1">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $product->id }}" />
                                        <input type="hidden" name="product_name" value="{{ $product->name}}" />
                                        <input type="hidden" name="price" value="{{ $product->price }}" />
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p>{{ $product->description }}</p>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    @foreach ($product->productReviews as $review)
                                        <div class="d-flex mb-4">
                                            <!-- User Avatar -->
                                            <i class="bi bi-person-circle fs-2"></i>
                                            <div class="ms-3">
                                                <!-- Customer Name -->
                                                <h5 class="mb-1">{{ $review->customer->name ?? 'Anonymous' }}</h5>
                                                <!-- Rating Stars -->
                                                <div>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <!-- Review Comment -->
                                                <p class="mb-1">{{ $review->comment }}</p>
                                                <!-- Review Date -->
                                                <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <h4 class="mb-5 fw-bold">Leave a Review</h4>
                            <div class="row g-4">
                                <!-- Rating Selection -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Please rate:</label>
                                        <select name="rating" id="rating" class="form-select" required>
                                            <option value="" disabled selected>Select your rating</option>
                                            <option value="1">1 - Poor</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="3">3 - Good</option>
                                            <option value="4">4 - Very Good</option>
                                            <option value="5">5 - Excellent</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Comment/Review -->
                                <div class="col-lg-12">
                                    <div class="border-bottom rounded my-4">
                                        <textarea name="comment" class="form-control border-0" cols="30" rows="8" placeholder="Your Review *" spellcheck="false" required></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-end py-3">
                                        <button type="submit" class="btn border border-secondary text-primary rounded-pill px-4 py-3">Submit Review</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection
