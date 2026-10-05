<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'condition',
        'image',
        'location',
        'status',
    ];

    // ของชิ้นนี้เป็นของผู้ใช้คนไหน
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ของชิ้นนี้อยู่ในหมวดหมู่ไหน
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ของชิ้นนี้มีความคิดเห็นอะไรบ้าง
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ของชิ้นนี้มีคนขอรับกี่คน
    public function requests()
    {
        return $this->hasMany(RequestItem::class);
    }
}
