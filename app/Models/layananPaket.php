<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class layananPaket extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table = 'layanan_paket';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
           $data->status =1;
        });
    }
}
