<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false; // Tắt vì database của bạn không có cột updated_at

    protected $fillable = [
        'user_id', 'total_amount', 'status', 'shipping_address', 'note', 'created_at'
    ];
}