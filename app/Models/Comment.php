<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'comment',
        'rating',
    ];

    // คนที่แสดงความคิดเห็น
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ของที่ถูกแสดงความคิดเห็น
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
