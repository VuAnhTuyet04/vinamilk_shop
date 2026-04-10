<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Khai báo tên bảng (vì bạn dùng bảng tên là categories)
    protected $table = 'categories';

    // Cho phép Laravel lưu dữ liệu vào các cột này
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    // Tắt timestamps nếu trong database của bạn không có cột created_at/updated_at
    // Trong file app/Models/Category.php
    public $timestamps = false;

}