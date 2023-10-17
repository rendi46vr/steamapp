<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual;

class layanan extends Model
{
    use HasFactory;

    protected $guarded = ["id"];


    public function tjual()
    {
        return $this->hasMany(tjual::class);
    }
}
