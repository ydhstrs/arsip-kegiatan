<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Buying extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'transaction_no',
    'name',
    'buying_date',
    'price',
    'image',
    'remark',
    'created_by',
    ];
protected $dates = ['deleted_at'];
}
