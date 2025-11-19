<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
    'id_bill',
    'guest_job',
    'marital_status',
    'idcard_no',
    'born_place',
    'birth_date',
    'checkin_date',
    'room_id',
    'idcard_image',
    'guest_image',
    'remark',
    'created_by',
    ];
}
