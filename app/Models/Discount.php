<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'discount_category_id',
        'product_id',
        'discount_percentage',
        'valid_from',
        'valid_to',
    ];

    // Relasi dengan DiscountCategory
    public function discount_category()  // gunakan singular karena belongsTo
    {
        return $this->belongsTo(Discount_Categories::class, 'discount_category_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Mengecek apakah diskon aktif
    public function getIsActiveAttribute()
    {
        $now = now();
        return $this->valid_from <= $now && $this->valid_to >= $now;
    }
}
