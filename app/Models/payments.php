<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual;

class payments extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function tjual()
    {
        return $this->belongsTo(tjual::class, "SessionId", "np");
    }
}
