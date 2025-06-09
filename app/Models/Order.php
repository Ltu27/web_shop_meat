<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const SEARCH_FIELDS = [
    ];

    public const FROM_FIELDS = [
    ];

    public const TO_FIELDS = [
    ];

    public const IN_SET_FIELDS = [
    ];

    public const HAS_FIELDS = [
    ];
    public const FILTER_FIELDS = [
        'status' => 'orders.status',
    ];

    public const SORT_FIELDS = [
        // 'id' => 'campaigns.id',
    ];

    protected $appends = ['totalPrice'];

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'token', 'customer_id', 'status',
        'total_price',
        'payment_type',
    ];

    public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function details() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function getTotalPriceAttribute() {
        $t = 0;
        foreach ($this->details as $item) {
            $t += $item->price * $item->quantity;
        }
        return $t;
    }
}
