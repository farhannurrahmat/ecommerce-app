<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wishlist;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount && $this->discount->is_active) {
            $discountPercentage = $this->discount->discount_percentage;
            return $this->price - ($this->price * $discountPercentage / 100);
        }

        return $this->price;
    }

    // Mengecek apakah produk memiliki diskon aktif
    public function getIsDiscountedAttribute()
    {
        return $this->discount && $this->discount->is_active;
    }
}
