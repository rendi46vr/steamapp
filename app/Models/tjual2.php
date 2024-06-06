<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual;
use App\Models\layanantambahan;

class tjual2 extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ["id", "tjual_id", "layanantambahan_id", "harga", "diskon"];


    public function tjual()
    {
        return  $this->belongsTo(tjual::class, 'tjual_id', 'id');
    }
    public function layanantambahan()
    {
        return  $this->hasOne(layanantambahan::class, 'id', 'layanantambahan_id');
    }
}
