<?php

namespace App\Models;

use App\Tools\tools;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patner extends Model
{
    use HasFactory;
    
    protected $table = 'patner';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        // Event creating untuk mengisi kolom status dengan nilai 1
        static::creating(function ($patner) {
            $patner->status = 1;
        });
    }

    public function hutang(){
        return tools::rupiah($this->hutang);
    }
    
    public function bayar(){
        return $this->hasMany(Bayar::class, 'patner_id', 'id');
    }

    //relasi ke tjual
    public function tjual(){
        return $this->hasMany(tjual::class, 'patner_id', 'id');
    }
    
}
