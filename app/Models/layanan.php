<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tjual;
use DateInterval;
use DateTime;
use stdClass;

class layanan extends Model
{
    use HasFactory;

    protected $guarded = ["id"];


    public function tjual()
    {
        return $this->hasMany(tjual::class);
    }

    public function paket(){
        return $this->hasMany(layananPaket::class);
    }

    public function layanan(){
        $obj = new stdClass();
        $obj->name = "Layanan Utama";
        $obj->namapaket =$this->layanan;
        $obj->paket ="";
        $obj->harga = $this->harga;
        $obj->diskon = $this->diskon;
        $obj->durasi = null; //30 hari
        $obj->start_at = null;
        $obj->end_at = null;
        $obj->type_layanan = $this->type;
        if($this->type != 0){
            if(session()->has('paket_id')){
                $harga =  layananPaket::find(session('paket_id'));
                $obj->name ="Layanan Utama(".$harga->nama_paket.")";
                $obj->namapaket =$this->layanan ." (".$harga->nama_paket.")";
                $obj->harga = $harga->harga;
                $obj->paket = $harga->nama_paket;
                $obj->diskon = $harga->diskon;
                $obj->durasi = $harga->durasi;
                $startDate = new DateTime(date('Y-m-d'));
                $endDate = clone $startDate; // Cloning to keep the original start date
                $endDate->add(new DateInterval('P' . ($obj->durasi - 1) . 'D')); // Adding (durasi - 1) days
                $obj->end_at = $endDate->format('Y-m-d');
            }else{
                $obj->harga = 0;
                $obj->diskon = 0;
            }
        }
        return $obj;
    }
}
