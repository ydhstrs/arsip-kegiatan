<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class Letter extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['no','uuid', 'file', 'source', 'remark', 'remark_kabid', 'remark_kasi', 'kasi_user_id', 'kabid_user_id', 'desc', 'status', 'staff_user_id', 
    ];
    protected $dates = ['deleted_at'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function kasi()
    {
        return $this->belongsTo(User::class, 'kasi_user_id', 'id');
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_user_id', 'id');
    }
}
