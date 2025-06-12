<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['customer_id', 'product_id', 'price', 'quantity',
        'variant_id',
    ];

    public function prod() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function variant() {
        return $this->hasOne(ProductVariant::class, 'id', 'variant_id');
    }
}
