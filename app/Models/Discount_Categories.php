<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount_Categories extends Model
{
    use HasFactory;
    protected $table = 'discount_categories';
    protected $fillable = ['discount_name'];

    // Relasi dengan Discount
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
