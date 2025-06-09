<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'order_id', 'product_id', 'price', 'quantity',
        'variant_id',
    ];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function productVariant() {
        return $this->hasOne(ProductVariant::class, 'id', 'variant_id');
    }
}
