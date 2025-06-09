<?php

namespace App\Constants;
class OrderConstant
{
    const STATUS_PENDING = 0; // Chờ xác nhận
    const STATUS_CONFIRMED = 1; // Đã xác nhận
    const STATUS_NOT_YET_PAY = 2; // Chưa thanh toán
    const STATUS_PAID = 3; // Đã thanh toán
    const STATUS_DONE = 4; // Đã nhận hàng
    const STATUS_SHIPPED = 5; // Đã vận chuyển
    const STATUS_COMPLETED = 6; // Đã hủy

    const PAYMENT_METHOD_COD = 'cod'; // Thanh toán khi nhận hàng
    const PAYMENT_METHOD_ONLINE = 'online'; // Thanh toán trực tuyến

    public static function getLabel($status)
    {
        return match($status) {
            self::STATUS_PENDING => 'Chờ xác nhận',
            self::STATUS_CONFIRMED => 'Đã xác nhận',
            self::STATUS_NOT_YET_PAY => 'Chưa thanh toán',
            self::STATUS_PAID => 'Đã thanh toán',
            self::STATUS_DONE => 'Đã nhận hàng',
            self::STATUS_SHIPPED => 'Đã vận chuyển',
            self::STATUS_COMPLETED => 'Đã hủy',
            default => 'Không xác định'
        };
    }
}