<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tjual;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DiskonController;
use App\Mail\sendMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\layanan;
use App\Models\payget;
use App\Models\payments;
use App\Models\tjual1;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\layanantambahan;
use App\Models\tjual2;
use Illuminate\Support\Facades\Auth;

class pembelianCon extends Controller
{
    public function index(DiskonController $ds)
    {
        $today =  Carbon::today()->toDateString();


        if (Session::has('bayar')) {
            $data = tjual::find(session::get('bayar'));
            if ($data->status == 2) {
                session::forget('bayar');
                return redirect('tiket/' . $data->id);
            }
            return redirect('pembayaran/' . session::get('bayar'));
        }
        $layanan = layanan::where("type", 0)->where('isaktif', 1)->get();
        return view('index', compact('layanan'));
    }
    public function formorder($slug)
    {

        $payment = payget::where("status", 1)->get();
        try {
            $layanan = $this->tableorder($slug);
            Session(["order" => $slug]);
            $tambahan = layanan::where("type", ">", 0)->get();
            $lb = layanantambahan::where("isaktif", 1)->get();
            return view('order.form-order', compact("tambahan", "layanan", "slug", "payment", "lb"));
        } catch (\Throwable $th) {
            return redirect("/");
        }
    }

    public function tableorder($slug, $layanan_tambahan = [])
    {
        $layanan = layanan::where("slug", $slug)->first();
        array_push($layanan_tambahan, $layanan->id);
        $tambahan = layanantambahan::wherein("id", $layanan_tambahan)->get();
        return view('order.table-order', compact("tambahan", "layanan"))->render();
    }

    public function order(Request $request, ipaymuController $ip)
    {
        $validasiData = $request->validate([
            'tgl' => '',
            'wa' => 'required|numeric',
            'email' => 'required:email:dns',
            "plat" => "required",
            "metpem" => "required",
        ]);
        $lastRecord = tjual::latest()->first();
        if (strtoupper($validasiData["plat"]) == $lastRecord->plat) {
            $createdAt = Carbon::parse($lastRecord->created_at);
            $now = Carbon::now();
            if ($createdAt->diffInMinutes($now) < 5) {
                return response()->json([
                    "success" => true,
                    "data" => url("payment/" . $lastRecord->id)
                ]);
            }
        }

        $main = layanan::where("slug", Session("order"))->first();

        $metode = payget::where("channel_code", $validasiData["metpem"])->first();
        $tambahan = false;
        $lt = [];
        $lt[] = $main->id;
        //cek sip

        $jam = Carbon::now()->format('Y-m-d H:i:s');
        $sip = null; // Inisialisasi variabel $sip
        $waktu = Carbon::parse($jam);
        if ($waktu->isBetween('7:00', '15:30')) {
            $sip = '0';
        } elseif ($waktu->isBetween('15:31', '23:59')) {
            $sip = '1';
        }

        if (auth()->user()) {
            if (auth()->user()->sip == "3") {
                if ($waktu->isBetween('11:00', '20:00')) {
                    $sip = '3';
                }
            }
        }


        if ($request->addon) {
            $addlt = $request->addon;
            $tambahan = true;
            if (!is_array($addlt)) {
                $addlt = [$addlt];
            }


            $getProduct = layanantambahan::wherein("id", $addlt)->get();
            // return $getProduct->sum("harga") + $main->harga;
            $product = $getProduct->pluck("layanan")->toArray();
            array_push($product, $main->layanan);
            $qtyoption =   $getProduct->pluck("qtyoption")->toArray();
            $count = count($product);
            $qty = [];
            for ($i = 1; $i < $count; $i++) {
                array_push($qty, 1);
            }
            $harga =   $getProduct->pluck("harga")->toArray();
            array_push($harga, $main->harga);
            $amount = ($getProduct->sum("harga") - $getProduct->sum("diskon")) + ($main->harga - $main->diskon);
        } else {
            $product = [$main->layanan];
            $qty =   [$main->qtyoption];
            $harga =   [($main->harga - $main->diskon)];
            $amount = ($main->harga - $main->diskon);
        }
        $isaktif = 0;
        if ($qty > 1) {
            $isaktif = 1;
        }
        $noref = "INV" . date("YmdHis");
        try {
            $finduser = User::where("email", $validasiData["email"])->firstorFail();
            $userid = $finduser->id;
        } catch (\Throwable $th) {
            $userid = null;
        }

        if ($validasiData["metpem"] == "tunai") {
            $order = tjual::create([
                "id" => Str::uuid(),
                "metpem" => $metode->channel_code,
                "name" => null,
                "np" => $noref,
                "wa" => $validasiData["wa"],
                "email" => $validasiData["email"],
                "tgl" => date("Y-m-d"),
                "qty" => $main->qtyoption,
                "qtyterpakai" => 1,
                "layanan_id" => $main->id,
                "isaktif" => $isaktif,
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" =>  strtoupper($validasiData["plat"]),
                "user_id" => $userid,
                "sip" => $sip
            ]);
            $sts = 0;
            for ($i = 1; $i <= $main->qtyoption; $i++) {
                if (Auth::user()) {
                    $i == 1 ? $sts = 1 :  $sts = 0;
                }
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "diskon" => $main->diskon,
                    "name" => $main->layanan,
                    "status" => $sts
                ]);
            }
            if ($tambahan) {
                foreach ($getProduct as $gp) {
                    tjual2::create([
                        "id" => Str::uuid(),
                        "tjual_id"  => $order->id,
                        "layanantambahan_id" => $gp->id,
                        "harga" => $gp->harga,
                        "diskon" => $gp->diskon
                    ]);
                }
            }
            if (Auth::user()) {
                $order->input_by = auth()->user()->id;
                $order->save();
            }
            return response()->json([
                "success" => true,
                "data" => url("payment/" . $order->id)
            ]);
        }
        $reqPayment = $ip->reqPayment([
            'product' => $product,
            'qty' => $qty,
            'amount' => $amount,
            'price' => $harga,
            'referenceId' =>  $noref,
            'paymentMethod' => $metode->code,
            'paymentChannel' => $metode->channel_code,
            'name' => strtoupper($validasiData["plat"]),
            'phone' =>  $validasiData["wa"],
            'email' => $validasiData["email"]
        ]);
        if ($reqPayment["Status"] == 200) {
            $createPayment = $reqPayment["Data"];
            $payment = payments::create($createPayment);
            $order = tjual::create([
                "id" => Str::uuid(),
                "metpem" => $metode->channel_code,
                "name" => null,
                "np" => $noref,
                "wa" => $validasiData["wa"],
                "email" => $validasiData["email"],
                "tgl" => date("Y-m-d"),
                "qty" => $main->qtyoption,
                "qtyterpakai" => 1,
                "isaktif" => $isaktif,
                "layanan_id" => $main->id,
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => strtoupper($validasiData["plat"]),
                "user_id" => $userid,
                "sip" => $sip
            ]);
            for ($i = 1; $i <= $main->qtyoption; $i++) {
                if (Auth::user()) {
                    $i == 1 ? $sts = 1 :  $sts = 0;
                }
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "diskon" => $main->diskon,
                    "name" => $main->layanan,
                    "status" => $sts
                ]);
            }
            if ($tambahan) {
                foreach ($getProduct as $gp) {

                    tjual2::create([
                        "id" => Str::uuid(),
                        "tjual_id"  => $order->id,
                        "layanantambahan_id" => $gp->id,
                        "harga" => $gp->harga,
                        "diskon" => $gp->diskon

                    ]);
                }
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ]);
        }
        if (Auth::user()) {
            $order->input_by = auth()->user()->id;
            $order->save();
        }
        return response()->json([
            "success" => true,
            "data" => url("payment/" . $order->id)
        ]);
        // return redirect("payment/" . $order->id);
    }
    public function bayar($slug)
    {
        try {
            $tjual = tjual::findOrFail($slug);
            if ($tjual->status == 2) {
                Session::forget('bayar');
                return redirect('tiket/' . $tjual->id);
            }
            return view('bayar', compact('tjual'));
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }

    public function tambahlayanan(Request $request)
    {
        $validasiData = $request->validate([
            "tambahan" => ""
        ]);
        if ($request->ajax()) {
            // dd($request);
            if ($request->has('tambahan')) {
                $array = $request->tambahan;
            } else {
                $array = [];
            }
            $data =  $this->tableorder(session("order"), $array);

            return response()->json([
                "status" => true,
                "data" => $data
            ]);
        }
    }

    public function cetaknota($slug)
    {
        // try {
        $tjual = tjual::findOrFail($slug);
        $tjual1 = tjual1::where("tjual_id", $tjual->id)->where("status", 1)->get();
        if (Session()->has("user")) {
            session()->forget("user");
        }
        if ($tjual->status == "berhasil") {
            $addon = tjual2::where("tjual_id", $tjual->id)->get();

            $data = view("invoice", compact("tjual", "tjual1", 'addon'))->render();
            return $data;
        } else {
            return "ok";
        }
    }
    public function tiket($slug)
    {
        try {
            if (auth()->check()) {
                $tjual = tjual::findOrFail($slug);
            } else {
                $tjual = tjual::findOrFail($slug);
            }

            if ($tjual->status ==  "berhasil") {

                $tikets = tjual1::where("tjual_id", $slug)->get();
                // if ($tjual->wa == "download2") {
                //     if ($tjual->info == null) {
                //         $pdf = Pdf::loadView('download', compact('tjual', 'tikets'))->setPaper('A8', 'portrait')->setWarnings(false);
                //     } else {
                //         $pdf = Pdf::loadView('download2', compact('tjual', 'tikets'))->setPaper('A8', 'portrait')->setWarnings(false);
                //     }
                // } else {
                //     $pdf = Pdf::loadView('download', compact('tjual', 'tikets'))->setPaper('A8', 'portrait')->setWarnings(false);
                // }
                Session::forget('bayar');
                // return $pdf->stream('tiket.pdf');tikets
                return view("download", compact("tjual", "tikets"));
            } else {
                return redirect('pembayaran/' . $tjual->id);
            }
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }

    public function tiketpdf($slug)
    {
        $tjual = tjual::findOrFail($slug);

        if ($tjual->status ==  "berhasil") {

            $tikets = tjual1::where("tjual_id", $slug)->get();
            $tjual1 = $tikets;
            $pdf = PDF::loadView('download2', compact('tjual', 'tikets'));
            $pdf->setPaper(array(0, 0, 250, 380));
            $tempFilePath = storage_path('app/public/qrcode.pdf');
            $pdf->save($tempFilePath);
            $addon = tjual2::where("tjual_id", $tjual->id)->get();
            $nota = PDF::loadView("download", compact("tjual", "tjual1", "addon"));
            $nota->setPaper(array(0, 0, 250, 580));
            $tempFilePathnota = storage_path('app/public/nota.pdf');
            $nota->save($tempFilePathnota);
            $sendnotif = [
                'title' => 'Pembelian  Berhasil!',
                'subject' => 'Steam App',
                'url' => '',
                'body' => 'Haloo Bapak/ibu , Silahkan download data Tiket Cuci Anda  dibawah: ',
            ];
            Mail::to($tjual->email)->send(new sendMail($sendnotif, $tempFilePath, $tempFilePathnota));

            unlink($tempFilePath);
            unlink($tempFilePathnota);
            // return $pdf->stream('download.pdf');
        }
    }

    public function find($id)
    {
        $search = htmlspecialchars($id);
        try {
            $pelanggan =  tjual::select('wa', 'email')->where('plat',  $search)->firstorFail();
            return response()->json([
                "success" => true,
                "wa" => $pelanggan->wa,
                "email" => $pelanggan->email,

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "wa" => "",
                "email" => ""

            ]);
        }
    }
}
