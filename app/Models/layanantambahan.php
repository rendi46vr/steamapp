<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual2;

class layanantambahan extends Model
{
    use HasFactory;
    protected $fillable = ["layanan", "id", "harga", "status", "diskon", 'isaktif'];
    public $incrementing = false;
    public function tjual2()
    {
        return  $this->hasMany(tjual2::class, 'layanantambahan_id', 'id');
    }
}
