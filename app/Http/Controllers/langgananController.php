<?php

namespace App\Http\Controllers;

use App\Models\tjual;
use App\Models\tjual1;
use App\Models\tjual2;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\pembelianCon;
class langgananController extends Controller
{
    //
    public function langganan($slug){
        $pay = tjual::with(["dataorder", "payget", "payment", "addon"])->findOrFail($slug);
        $pemakaian = tjual1::where('tjual_id', $pay->id)->orderBy('created_at','asc')->get();
        
        $addon = tjual2::with("layanantambahan")->where("tjual_id", $slug)->get();

        return view("langganan.index", compact("pay", "addon",'pemakaian'));
    }

    public function langgananDetail(){

    }


    public function pakaiLangganan($slug){
        DB::beginTransaction();
        try {
        $tjual = tjual::with('layanan')->where('type_layanan',1)->where('id', $slug)->first();
        $data = tjual1::create([
            "id" => Str::uuid(),
            "tjual_id" => $tjual->id,
            "layanan_id" => $tjual->layanan->id,
            "harga" => 0,
            "diskon" =>0,
            "opsiqty" => 1,
            "name" => $tjual->layanan->layanan,
            "status" => 1
        ]);
        
        DB::commit();
        //send notif Wa
        $notif = new pembelianCon();
        $notif->tiketpdf($tjual->id);
        if($data){
            return response()->json([
                "status"=> true,
                "redirect"=> redirect('langganan/'.$tjual->id)
            ]);
        }
    } catch (\Throwable $th) {
        //throw $th;
        DB::rollBack();
        throw $th;
       
    }
    return response()->json([
        "status"=> false,
        "redirect"=> ''
    ]);

    }
}
