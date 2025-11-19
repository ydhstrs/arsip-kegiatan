<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['transaction_no', 'bill_date', 'payment_date', 'guest_name', 'image', 'room_id', 'checkin_id', 'amount', 'duration', 'created_by'];
    protected $dates = ['deleted_at'];
    public function room()
    {
        return $this->hasOne(Room::class, 'id', 'room_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
