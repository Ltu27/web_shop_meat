<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
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
    ];

    public const SORT_FIELDS = [
        'id' => 'coupons.id',
    ];

    protected $fillable = [
        'code',
        'discount',
        'end_date',
        'quantity',
        'status',
    ];

    public function getDiscountPercent()
    {
        return $this->discount / 100;
    }
}
