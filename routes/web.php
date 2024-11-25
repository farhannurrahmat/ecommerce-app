    <?php

    use App\Http\Middleware\AuthAdmin;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\ShopController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\Auth\CustomerAuthController;
    use App\Http\Controllers\ProductReviewController;
    use App\Http\Controllers\WishlistController;
    use App\Http\Controllers\CheckoutController;
    use App\Http\Controllers\OrderController;


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    Auth::routes();

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{id}', [ShopController::class, 'product_details'])->name('shop.product.details');

    Route::prefix('customer')->group(function () {
        Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login')->middleware('guest:customer');;
        Route::post('login', [CustomerAuthController::class, 'login']);
        Route::post('logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
        Route::get('register', [CustomerAuthController::class, 'showRegistrationForm'])->name('customer.register');
        Route::post('register', [CustomerAuthController::class, 'register']);
    });

    Route::middleware('auth:customer')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::patch('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');

        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
        Route::post('/wishlist/add-to-cart/{id}', [WishlistController::class, 'addToCart'])->name('wishlist.addToCart');

        Route::post('/reviews', [ProductReviewController::class, 'store'])->name('reviews.store');

        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    });

    Route::middleware(['auth', AuthAdmin::class])->group(function () {
        Route::get('/admin-page', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin-page/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/admin-page/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
        Route::post('/admin-page/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
        Route::get('/admin-page/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
        Route::put('/admin-page/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
        Route::delete('/admin-page/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

        Route::get('/admin-page/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/admin-page/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
        Route::post('/admin-page/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
        Route::get('/admin-page/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
        Route::put('/admin-page/product/{id}/update', [AdminController::class, 'product_update'])->name('admin.product.update');
        Route::delete('/admin-page/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

        Route::get('/admin-page/discount-categories', [AdminController::class, 'discount_categories'])->name('admin.discount-categories.index');
        Route::get('/admin-page/discount-categories/create', [AdminController::class, 'discount_categories_create'])->name('admin.discount-categories.create');
        Route::post('/admin-page/discount-categories', [AdminController::class, 'discount_categories_store'])->name('admin.discount-categories.store');
        Route::get('/admin-page/discount-categories/{id}/edit', [AdminController::class, 'discount_categories_edit'])->name('admin.discount-categories.edit');
        Route::put('/admin-page/discount-categories/{id}', [AdminController::class, 'discount_categories_update'])->name('admin.discount-categories.update');
        Route::delete('/admin-page/discount-categories/{id}', [AdminController::class, 'discount_categories_destroy'])->name('admin.discount-categories.destroy');

        // Diskon
        Route::get('/admin-page/discounts', [AdminController::class, 'discounts'])->name('admin.discounts.index');
        Route::get('/admin-page/discounts/create', [AdminController::class, 'discount_create'])->name('admin.discounts.create');
        Route::post('/admin-page/discounts', [AdminController::class, 'discount_store'])->name('admin.discounts.store');
        Route::get('/admin-page/discounts/{id}/edit', [AdminController::class, 'discount_edit'])->name('admin.discounts.edit');
        Route::put('/admin-page/discounts/{id}', [AdminController::class, 'discount_update'])->name('admin.discounts.update');
        Route::delete('/admin-page/discounts/{id}', [AdminController::class, 'discount_destroy'])->name('admin.discounts.destroy');

        Route::get('/admin-page/orders', [AdminController::class, 'orders'])->name('admin.orders');
    });
