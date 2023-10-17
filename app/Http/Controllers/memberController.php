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
use App\Tools\tools;

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

            try {
                $tjual = tjual::where("id", $tjual1->tjual_id)->where("isaktif", 1)->firstOrFail();
                $main = layanan::find($tjual->layanan_id);
                $tjual->qtyterpakai = $tjual->qtyterpakai + 1;
                $tjual->save();
                if ($tjual->qtyterpakai >= $tjual->qty) {
                    $tjual->isaktif = 0;
                    $tjual->save();
                }
                $tjual1->status = 1;
                $tjual1->save();
                return response()->json([
                    "success" => true,
                    "msg" => "Order " . $main->layanan . " Berhasil",
                    "data" => $pc->cetaknota($tjual->id)
                ]);
            } catch (\Throwable $th) {
                $tjual = tjual::with("layanan")->where("tjual_id", $tjual1->tjual_id)->latest()->first();
                Session::put("user", ["uid" => "", "plat" => $tjual->plat, "email" => $tjual->email, "wa" => $tjual->wa, "latest" => $tjual->layanan->slug]);
                return response()->json([
                    "success" => false,
                    "lanjut" => true,
                    "msg" => "Saldo Cuci Habis <br>Mau Beli Paket " . $tjual->layanan->layanan . " (" . tools::fRupiah($tjual->layanan->harga) . ") Lagi?",
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
}
