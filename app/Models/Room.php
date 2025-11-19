<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Room extends Model
{
    use HasFactory, SoftDeletes;
      protected $fillable = [
    'name',
    'price',
    'type',
    'image',
    'remark',
    'is_available',
    'floor',
    ];

protected $dates = ['deleted_at'];
    public function bill(){
        return $this->hasMany(Bill::class,"room_id","id");
    }
}
