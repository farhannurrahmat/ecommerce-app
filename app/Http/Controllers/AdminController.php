<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount_Categories;
use App\Models\Discount;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category_add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully');
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category_edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $category = Category::find($request->id);
        $category->category_name = $request->category_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully');
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'category_name')->orderBy('category_name')->get();
        return view('admin.product_add', compact('categories'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stok_quantity' => 'required',
            'image1_url' => 'required|mimes:png,jpg,jpeg|max:2048',
            'image2_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'image3_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'image4_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'image5_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
        ]);

        try {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stok_quantity = $request->stok_quantity;
            $product->category_id = $request->category_id;

            // Upload Gambar
            for ($i = 1; $i <= 5; $i++) {
                $imageField = "image{$i}_url";
                if ($request->hasFile($imageField)) {
                    $image = $request->file($imageField);
                    $imageName = time() . "_$i." . $image->getClientOriginalExtension();

                    $this->saveImageWithThumbnail($image, $imageName);
                    $product->$imageField = $imageName;
                }
            }

            $product->save();
            return redirect()->route('admin.products')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
        }
    }

    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select('id', 'category_name')->orderBy('category_name')->get();
        return view('admin.product_edit', compact('product', 'categories'));
    }

    public function product_update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|max:100',
            'description' => 'required|max:1000',
            'price' => 'required|integer|min:0',
            'stok_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image1_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'image2_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'image3_url' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->product_name = $request->product_name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stok_quantity = $request->stok_quantity;
            $product->category_id = $request->category_id;

            for ($i = 1; $i <= 3; $i++) {
                $imageField = "image{$i}_url";
                if ($request->hasFile($imageField)) {
                    $image = $request->file($imageField);
                    $imageName = time() . "_{$i}." . $image->getClientOriginalExtension();

                    $oldImagePath = public_path("uploads/products/" . $product->$imageField);
                    $oldThumbnailPath = public_path("uploads/products/thumbnails/" . $product->$imageField);

                    if (File::exists($oldImagePath)) File::delete($oldImagePath);
                    if (File::exists($oldThumbnailPath)) File::delete($oldThumbnailPath);

                    $this->saveImageWithThumbnail($image, $imageName);
                    $product->$imageField = $imageName;
                }
            }

            $product->save();
            return redirect()->route('admin.products')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }


    public function product_delete($id)
    {
        $product = Product::findOrFail($id);

        // Delete image files
        if ($product->image1_url) {
            $image_path = public_path('uploads/products/' . $product->image1_url);
            $thumb_path = public_path('uploads/products/thumbnails/' . $product->image1_url);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }
        }
        if ($product->image2_url) {
            $image_path = public_path('uploads/products/' . $product->image2_url);
            $thumb_path = public_path('uploads/products/thumbnails/' . $product->image2_url);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }
        }
        if ($product->image3_url) {
            $image_path = public_path('uploads/products/' . $product->image3_url);
            $thumb_path = public_path('uploads/products/thumbnails/' . $product->image3_url);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }
        }
        if ($product->image4_url) {
            $image_path = public_path('uploads/products/' . $product->image4_url);
            $thumb_path = public_path('uploads/products/thumbnails/' . $product->image4_url);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }
        }
        if ($product->image5_url) {
            $image_path = public_path('uploads/products/' . $product->image5_url);
            $thumb_path = public_path('uploads/products/thumbnails/' . $product->image5_url);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully');
    }

    protected function saveImageWithThumbnail($image, $imageName)
    {
        $destinationPath = public_path('uploads/products');
        $thumbnailPath = public_path('uploads/products/thumbnails');

        // Pastikan folder ada
        File::ensureDirectoryExists($destinationPath);
        File::ensureDirectoryExists($thumbnailPath);

        // Simpan gambar utama
        $img = Image::read($image->getRealPath());
        $img->resize(540, 689)->save($destinationPath . '/' . $imageName);

        // Simpan thumbnail
        $img->resize(104, 104)->save($thumbnailPath . '/' . $imageName);
    }

    public function discount_categories()
    {
        $discount_categories = Discount_Categories::all();
        return view('admin.discount_categories', compact('discount_categories'));
    }

    // Menampilkan form untuk membuat kategori diskon
    public function discount_categories_create()
    {
        return view('admin.discount_category_add');
    }

    // Menyimpan kategori diskon
    public function discount_categories_store(Request $request)
    {
        $request->validate([
            'discount_name' => 'required|string|max:255',
        ]);

        Discount_Categories::create([
            'discount_name' => $request->discount_name,
        ]);

        return redirect()->route('admin.discount-categories.index')->with('success', 'Kategori Diskon berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori diskon
    public function discount_categories_edit($id)
    {
        $discount_categories = Discount_Categories::findOrFail($id);
        return view('admin.discount_category_edit', compact('discount_categories'));
    }

    // Mengupdate kategori diskon
    public function discount_categories_update(Request $request, $id)
    {
        $discount_categories = Discount_Categories::findOrFail($id);

        $request->validate([
            'discount_name' => 'required|string|max:255',
        ]);

        $discount_categories->update([
            'discount_name' => $request->discount_name
        ]);

        return redirect()->route('admin.discount-categories.index')->with('success', 'Kategori Diskon berhasil diperbarui!');
    }

    // Menghapus kategori diskon
    public function discount_categories_destroy($id)
    {
        $discount_categories = Discount_Categories::findOrFail($id);
        $discount_categories->delete();

        return redirect()->route('admin.discount-categories.index')->with('success', 'Kategori Diskon berhasil dihapus!');
    }

    public function discounts()
    {
        $discounts = Discount::with(['product', 'discount_category'])->get();
        return view('admin.discounts', compact('discounts'));
    }

    // Menampilkan form untuk membuat diskon
    public function discount_create()
    {
        $discount_categories = Discount_Categories::all();
        $products = Product::all();

        return view('admin.discount_add', compact('discount_categories', 'products'));
    }

    // Menyimpan diskon
    public function discount_store(Request $request)
    {
        $request->validate([
            'discount_category_id' => 'required|exists:discount_categories,id',
            'product_id' => 'required|exists:products,id',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);

        Discount::create([
            'discount_category_id' => $request->discount_category_id,
            'product_id' => $request->product_id,
            'discount_percentage' => $request->discount_percentage,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit diskon
    public function discount_edit($id)
    {
        $discount = Discount::findOrFail($id);
        $products = Product::all();
        $discount_categories = Discount_Categories::all();
        return view('admin.discount_edit', compact('discount', 'discount_categories', 'products'));
    }

    // Mengupdate diskon
    public function discount_update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $request->validate([
            'discount_category_id' => 'required|exists:discount_categories,id',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after_or_equal:valid_from',
        ]);

        $discount->update([
            'discount_category_id' => $request->discount_category_id,
            'discount_percentage' => $request->discount_percentage,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    // Menghapus diskon
    public function  discount_destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('admin.discounts.index')->with('success', 'Diskon berhasil dihapus!');
    }

    public function orders()
    {
        // Ambil data pesanan, dengan mengurutkan berdasarkan tanggal pesanan terbaru
        $orders = Order::orderBy('created_at', 'DESC')->paginate(10);

        // Mengirim data pesanan ke view
        return view('admin.orders', compact('orders'));
    }
}
