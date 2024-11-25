@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Add Product</div>
                    </li>
                </ul>
            </div>

            <!-- Form -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">
                @csrf

                <!-- Product Details -->
                <div class="wg-box">
                    <!-- Product Name -->
                    <fieldset>
                        <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="product_name" value="{{ old('product_name') }}"
                            placeholder="Enter product name" maxlength="100" required>                        @error('product_name')
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <!-- Category -->
                    <fieldset>
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <select name="category_id" required>
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <!-- Description -->
                    <fieldset>
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-5" name="description" placeholder="Enter product description" maxlength="1000" required>{{ old('description') }}</textarea>
                        <div class="text-tiny">Max 100 characters.</div>
                        @error('description')
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="Enter price"
                            min="0" required>
                        @error('price')
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <!-- Stok Quantity -->
                    <fieldset>
                        <div class="body-title mb-10">Stok Quantity <span class="tf-color-1">*</span></div>
                        <input type="number" name="stok_quantity" value="{{ old('stok_quantity') }}"
                            placeholder="Enter stock quantity" min="1" required>
                        @error('stok_quantity')
                            <span class="alert alert-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>
                </div>

                <!-- Images -->
                <div class="wg-box">
                    <div class="row">
                        <div class="col-md-6">
                            @for ($i = 1; $i <= 3; $i++)
                                <fieldset>
                                    <div class="body-title">Upload Image {{ $i }} <span
                                            class="tf-color-1">*</span></div>
                                    <div class="upload-image flex-grow">
                                        <div class="item" id="imgpreview{{ $i }}" style="display:none">
                                            <img src="#" class="effect8" alt="Image {{ $i }} Preview">
                                        </div>
                                        <div id="upload-file{{ $i }}" class="item up-load">
                                            <label class="uploadfile" for="myFile{{ $i }}">
                                                <span class="icon">
                                                    <i class="icon-upload-cloud"></i>
                                                </span>
                                                <span class="body-text">Drop your image here or select <span
                                                        class="tf-color">click to browse</span></span>
                                                <input type="file" id="myFile{{ $i }}"
                                                    name="image{{ $i }}_url" accept="image/*">
                                            </label>
                                        </div>
                                    </div>
                                    @error("image{$i}_url")
                                        <span class="alert alert-danger text-center">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            @endfor
                        </div>
                        <div class="col-md-6">
                            @for ($i = 4; $i <= 5; $i++)
                                <fieldset>
                                    <div class="body-title">Upload Image {{ $i }} <span
                                            class="tf-color-1">*</span></div>
                                    <div class="upload-image flex-grow">
                                        <div class="item" id="imgpreview{{ $i }}" style="display:none">
                                            <img src="#" class="effect8" alt="Image {{ $i }} Preview">
                                        </div>
                                        <div id="upload-file{{ $i }}" class="item up-load">
                                            <label class="uploadfile" for="myFile{{ $i }}">
                                                <span class="icon">
                                                    <i class="icon-upload-cloud"></i>
                                                </span>
                                                <span class="body-text">Drop your image here or select <span
                                                        class="tf-color">click to browse</span></span>
                                                <input type="file" id="myFile{{ $i }}"
                                                    name="image{{ $i }}" accept="image/*" >
                                            </label>
                                        </div>
                                    </div>
                                    @error("image{$i}")
                                        <span class="alert alert-danger text-center">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                            @endfor
                        </div>
                    </div>
                </div>
                <div>
                    <button class="tf-button w-full" type="submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview images dynamically
        for (let i = 1; i <= 5; i++) {
            document.getElementById(`myFile${i}`).addEventListener('change', function() {
                previewImage(i, this.files[0]);
            });
        }

        function previewImage(index, file) {
            const previewContainer = document.getElementById(`imgpreview${index}`);
            const previewImage = previewContainer.querySelector('img');

            if (file) {
                previewContainer.style.display = 'block';
                previewImage.src = URL.createObjectURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
@endpush
