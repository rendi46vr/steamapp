<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual1;
use App\Models\User;
use App\Models\payments;
use App\Models\payget;

class tjual extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = ['id', "metpem", 'np', 'name', 'wa', 'email', 'tgl', 'tgljual', 'qty', 'totalbayar', 'token', 'status', 'tiket_id', "jenis_kendaraan", 'user_id', 'iscetak', "plat"];


    public function dataorder()
    {
        return  $this->hasMany(tjual1::class);
    }
    public function payment()
    {
        return  $this->hasOne(payments::class, "SessionId", "np");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payget()
    {
        return $this->belongsTo(payget::class, "metpem", "channel_code");
    }
}
