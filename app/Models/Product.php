<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $appends = ['favorited'];

    protected $fillable = ['name', 'status', 'price', 'sale_price', 'image', 'category_id', 'description',
        'quantity',
    ];

    public function cat() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function getFavoritedAttribute() {
        $favorited = Favorite::where(['product_id' => $this->id, 'customer_id' => auth('cus')->id()])->first();
        return $favorited ? true : false;
    }

    public function comment() 
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function variants() 
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
}
