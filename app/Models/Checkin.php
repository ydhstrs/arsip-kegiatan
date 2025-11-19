<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['transaction_no', 'checkin_date', 'transaction_date', 'duration', 'guest_name', 'guest_job', 'marital_status', 'idcard_no', 'born_place', 'birth_date', 'room_id', 'user_id', 'room_price', 'amount', 'idcard_image', 'guest_image', 'remark', 'created_by'];
    protected $dates = ['deleted_at'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'id', 'checkin_id');
    }
}
