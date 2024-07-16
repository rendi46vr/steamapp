<?php

namespace App\Http\Controllers;

use App\Models\tjual;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\tjual1;
use App\Models\layanan;
use App\Http\Controllers\pembelianCon;
use App\Models\Patner;
use App\Tools\tools;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Symfony\Component\CssSelector\Node\FunctionNode;

class memberController extends Controller
{
    public function create($id, UserController $ts)
    {
        $calonmember = tjual::find($id);
        try {
            $member = User::create([
                "name" => $calonmember->email,
                "email" => $calonmember->email,
                "password" => bcrypt("345678910"),
                "role" => "member",
                "member_id" => Str::uuid()
            ]);

            $calonmember->user_id = $member->id;
            $calonmember->save();
            if ($member) {
                return response()->json([
                    "status" => true,
                    "data" => $ts->tabletransaksi()
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "data" => ""
            ]);
        }
    }
    public function scan()
    {
        // Session::put("navbarhide", true);
        return view("order.scan");
    }

    public function memberorder($id, pembelianCon $pc)
    {
        try {
            $tjual1 = tjual1::where('id', $id)->where("status", 0)->firstorFail();
            $isSubscribe = false;
            $cek = tjual::where(['id'=>$tjual1->tjual_id, 'type_layanan'=> 1])->first();
            if($cek){
                $isSubscribe = true;
            }
            try {
                $tjual = tjual::where("id", $tjual1->tjual_id)->where("isaktif", 1)->firstOrFail();
                $main = layanan::find($tjual->layanan_id);
                if($isSubscribe){
                    $cek2 = tjual1::where('tjual_id', $tjual1->tjual_id)->where('created_at', '>=', Carbon::now()->subHour())->first();
                    if (!$cek2) {
                        tjual1::create([
                            "id" => Str::uuid(),
                            "tjual_id" => $tjual->id,
                            "layanan_id" => $main->id,
                            "harga" => 0,
                            "diskon" =>0,
                            "opsiqty" => 1,
                            "name" => $main->layanan,
                            "status" => 1
                        ]);
                    }
                    $tjual->qtyterpakai =  $tjual->qtyterpakai +1;
                    if($tjual->patner_id != null){
                        $tjual->status= "berhasil";
                    }
                    $tjual->save();
                    $msg = "Paket " . $main->layanan . " Berhasil digunakan";
                }else{
                    $tjual->qtyterpakai = $tjual->qtyterpakai + 1;
                    $tjual->save();
                    if ($tjual->qtyterpakai >= $tjual->qty) {
                        $tjual->isaktif = 0;
                        $tjual->save();
                    }
                    $tjual1->status = 1;
                    $tjual1->save();
                    $msg = "Tiket/Qrcode " . $main->layanan . " Berhasil digunakan";
                }
                //jika tiket dari partnership
                if($tjual->patner_id != null){
                    $tjual->status = "berhasil";
                    $tjual->save();
                    $patner= Patner::find($tjual->patner_id);
                    $patner->hutang = $patner->hutang + $tjual->totalbayar;
                    $patner->save();
                    // $pc->sendNotifPartnership($tjual->id, false);
                }
                return response()->json([
                    "success" => true,
                    "msg" => $msg,
                    "data" => $pc->cetaknota($tjual->id),
                    'data_id'=>$tjual->id
                ]);
            } catch (\Throwable $th) {
                $tjual = tjual::with("layanan")->where("tjual_id", $tjual1->tjual_id)->latest()->first();
                Session::put("user", ["uid" => "", "plat" => $tjual->plat, "email" => $tjual->email, "wa" => $tjual->wa, "latest" => $tjual->layanan->slug]);
                return response()->json([
                    "success" => false,
                    "lanjut" => true,
                    "msg" => "Quota Cuci Habis <br>Mau Beli Paket " . $tjual->layanan->layanan . " (" . tools::fRupiah($tjual->layanan->harga) . ") Lagi?",
                    "id" => ""
                ]);
            }
            return $tjual;
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "lanjut" => false,
                "msg" => "Qr Code Tidak Valid",
            ]);
        }
    }
    public function belilagi($id)
    {
        $session = Session::get("user");
        return response()->json(url("form-order/" . $session["latest"]));
    }

    public function navhide()
    {
        if (Session::has("navbarhide")) {
            Session::forget("navbarhide");
        } else {
            Session::put("navbarhide", true);
        }
        return redirect()->back();
    }

    public function cetaklaporan($patner_id){
        $patner = Patner::find($patner_id);
        $transaksi = tjual::where('patner_id', $patner_id)->where('status_bayar', 0)->where()->get();
        $data=[];
        $data['patner']=$patner;
        $data['transaksi'] = $transaksi;

        $pdf = Pdf::loadView('patner.pembayaran.cetak-tagihan',$data)->setPaper('a4');
        return $pdf->stream('pdf');

    }

    public function downloadlaporan($patner_id){
        $patner = Patner::find($patner_id);
        $transaksi = tjual::where('patner_id', $patner_id)->where('status_bayar', 0)->get();
        $data=[];
        $data['patner']=$patner;
        $data['transaksi'] = $transaksi;

        $pdf = Pdf::loadView('patner.pembayaran.cetak-tagihan',$data)->setPaper('a4');
        return $pdf->download('Laporan-Transaksi.pdf');

    }
}
