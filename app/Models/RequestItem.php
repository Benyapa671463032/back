<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'item_id',
        'user_id',
        'message',
        'status',
    ];

    // ของที่ต้องการขอรับ
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // คนที่ขอรับ
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
