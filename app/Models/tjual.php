<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual1;
use App\Models\User;
use App\Models\payments;
use App\Models\payget;
use App\Models\layanan;
use App\Models\layanantambahan;
use Carbon\Carbon;

class tjual extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];


    public function dataorder()
    {
        return  $this->hasOne(tjual1::class,'tjual_id','id')->orderBy('created_at','asc');
    }
    public function payment()
    {
        return  $this->hasOne(payments::class, "SessionId", "np");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function by()
    {
        return $this->belongsTo(User::class, 'input_by', 'id');
    }
    public function layanan()
    {
        return $this->belongsTo(layanan::class);
    }
    public function payget()
    {
        return $this->belongsTo(payget::class, "metpem", "channel_code");
    }
    public function addon()
    {
        return  $this->hasMany(tjual2::class, "tjual_id", "id");
    }
    public function sisaSaldo($true =true){
        if($this->type_layanan == 1){
            if(!Carbon::parse($this->end_at)->isPast()){
                return $this->sisa_durasi. " Hari";
            }
            if($true){
                return '0 Hari. <font color="red">Langganan Berakhir</font>' ;
            }else{
                return '0 Hari' ;
            }
        }else{
            return $this->qty - $this->qtyterpakai . 'x Kali';
        }
    }
}
