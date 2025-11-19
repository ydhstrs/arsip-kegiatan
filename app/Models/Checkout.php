<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
    'room_id',
    'checkout_date',
    'remark',
    'created_by',
    ];
protected $dates = ['deleted_at'];


}
