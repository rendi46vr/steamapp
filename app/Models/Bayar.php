<?php

namespace App\Models;

use App\Tools\tools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Bayar extends Model
{
    use HasFactory;
    protected $table = 'bayar';
    protected $guarded = [];

    //function boot creating set kolom input_by = user_id and tgl = current_date
    protected static function boot(){
        parent::boot();
        static::creating(function($bayar){
            $bayar->input_by = auth()->user()->id;
            $bayar->tgl = date('Y-m-d');

            //create noref
            $latestBayar = self::orderByDesc('id')->first();
            $code = 'REB-000001';

            if ($latestBayar) {
                $code = ++$latestBayar->noref;
            }

            $bayar->noref = $code;
        });
    }

    public function statusHtml(){
        if($this->status == 0){
            return '<span class="badge badge-primary">Belum Disetujui</span>';
        } elseif($this->status == 1){
            return '<span class="badge badge-success">Disetujui</span>';
        } elseif($this->status == -1){
            return '<span class="badge badge-danger">Ditolak</span>';
        }elseif($this->status == -2){
            return '<span class="badge badge-danger">Batal</span>';
        }
    }

    public function patner(){
        return $this->hasOne(Patner::class, 'id', 'patner_id');
    }
    public function jumlah(){
        return tools::rupiah($this->jumlah);
    }
    public function hutang_saat_bayar(){
        return tools::rupiah($this->hutang_saat_bayar);
    }

}
