<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'transaction_type',
    'transaction_no',
    'guest_name',
    'room_id',
    'date',
    'amount',
    'created_by',
    ];
protected $dates = ['deleted_at'];

    public function room(){
        return $this->hasOne(Room::class,"id","room_id");
    }
}

