<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'production_date',
        'stock_quantity',
        'variant_color', 
        'variant_price', 
        'expiration_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
