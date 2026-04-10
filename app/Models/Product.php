<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    // Tắt timestamps tự động của Laravel để tránh lỗi thiếu cột updated_at
    public $timestamps = false; 

    protected $fillable = [
        'category_id', 'name', 'slug', 'price', 'discount_price', 
        'thumbnail', 'summary', 'content', 'stock_quantity', 
        'unit', 'is_active', 'expiry_date', 'created_at'
    ];
}