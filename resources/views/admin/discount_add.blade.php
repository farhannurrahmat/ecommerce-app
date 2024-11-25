@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Discount Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.discounts.index') }}">
                            <div class="text-tiny">Discounts</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Discount</div>
                    </li>
                </ul>
            </div>
            <!-- new-discount -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.discounts.store') }}" method="POST">
                    @csrf
                    <fieldset class="category">
                        <div class="body-title">Product <span class="tf-color-1">*</span></div>
                        <select name="product_id" class="flex-grow" required>
                            <option value="">Select Product </option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>
                    @error('discount_category_id')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Discount Percentage <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="number" placeholder="Discount Percentage" name="discount_percentage"
                            value="{{ old('discount_percentage') }}" required aria-required="true" min="1" max="100">
                    </fieldset>
                    @error('discount_percentage')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="category">
                        <div class="body-title">Discount Category <span class="tf-color-1">*</span></div>
                        <select name="discount_category_id" class="flex-grow" required>
                            <option value="">Select Category</option>
                            @foreach($discount_categories as $category)
                                <option value="{{ $category->id }}" {{ old('discount_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->discount_name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>
                    @error('discount_category_id')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="validity">
                        <div class="body-title">Valid From <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="date" name="valid_from" value="{{ old('valid_from') }}" required>
                    </fieldset>

                    <fieldset class="validity">
                        <div class="body-title">Valid To <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="date" name="valid_to" value="{{ old('valid_to') }}" required>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
