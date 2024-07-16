<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananPatner extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function layanan(){
        return $this->hasOne(Layanan::class, 'id', 'layanan_id');
    }
}
