<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomMove extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['from_room_id', 'to_room_id','guest_name', 'remark', 'move_date', 'created_by'];
    protected $dates = ['deleted_at'];
}
