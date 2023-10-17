<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $layanan = layanan::where("type", 0)->get();
        return view('index', compact('layanan'));
    }
    public function formorder($slug)
    {

        $payment = payget::where("status", 1)->get();


        try {
            $layanan = $this->tableorder($slug);
            Session(["order" => $slug]);
            $tambahan = layanan::where("type", ">", 0)->get();
            return view('order.form-order', compact("tambahan", "layanan", "slug", "payment"));
        } catch (\Throwable $th) {
            return redirect("/");
        }
    }

    public function tableorder($slug, $layanan_tambahan = [])
    {
        $layanan = layanan::where("slug", $slug)->first();
        array_push($layanan_tambahan, $layanan->id);

        $tambahan = layanan::wherein("id", $layanan_tambahan)->get();

        return view('order.table-order', compact("tambahan"))->render();
    }

    public function order(Request $request, ipaymuController $ip)
    {
        $validasiData = $request->validate([
            'tgl' => '',
            'email' => 'required:email:dns',
            "plat" => "required",
            "metpem" => "required",
        ]);
        $main = layanan::where("slug", Session("order"))->first();

        $metode = payget::where("channel_code", $validasiData["metpem"])->first();
        $tambahan = false;
        $lt = [];
        $lt[] = $main->id;



        if ($request->layanan_tambahan) {
            $addlt = $request->layanan_tambahan;
            $tambahan = true;
            if (is_array($addlt)) {
                array_push($addlt, $main->id);
                $lt = $addlt;
            } else {
                array_push($lt, $addlt);
            }
            $getProduct = layanan::wherein("id", $lt)->get();

            $product = $getProduct->pluck("layanan")->toArray();
            $qty =   $getProduct->pluck("qtyoption")->toArray();
            $harga =   $getProduct->pluck("harga")->toArray();
            $amount = $getProduct->sum("harga");
        } else {
            $product = [$main->layanan];
            $qty =   [$main->qtyoption];
            $harga =   [$main->harga];
            $amount = $main->harga;
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
            // return  [
            //     "id" => Str::uuid(),
            //     "metpem" => $metode->channel_code,
            //     "name" => null,
            //     "np" => $noref,
            //     "wa" => "089811982121",
            //     "email" => $validasiData["email"],
            //     "tgl" => date("Y-m-d"),
            //     "qty" => $qty[0],
            //     "qtyterpakai" => 1,
            //     "layanan_id" => $main->id,
            //     "isaktif" => $isaktif,
            //     "totalbayar" => $amount,
            //     "status" => "pending",
            //     "jenis_kendaraan" => null,
            //     "plat" => $validasiData["plat"],
            //     "user_id" => $userid
            // ];
            $order = tjual::create([
                "id" => Str::uuid(),
                "metpem" => $metode->channel_code,
                "name" => null,
                "np" => $noref,
                "wa" => "089811982121",
                "email" => $validasiData["email"],
                "tgl" => date("Y-m-d"),
                "qty" => $qty[0],
                "qtyterpakai" => 1,
                "layanan_id" => $main->id,
                "isaktif" => $isaktif,
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => $validasiData["plat"],
                "user_id" => $userid
            ]);
            for ($i = 1; $i <= $qty[0]; $i++) {
                $i == 1 ? $sts = 1 :  $sts = 0;
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "name" => $main->layanan,
                    "status" => $sts
                ]);
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
            'name' => $validasiData["plat"],
            'phone' =>  "089811982121",
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
                "wa" => "089811982121",
                "email" => $validasiData["email"],
                "tgl" => date("Y-m-d"),
                "qty" => $qty[0],
                "qtyterpakai" => 1,
                "isaktif" => $isaktif,
                "layanan_id" => $main->id,
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => $validasiData["plat"],
                "user_id" => $userid

            ]);
            $sts = 0;
            for ($i = 1; $i <= $qty[0]; $i++) {
                if ($i = 1) {
                    $sts = 1;
                }
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "name" => $main->layanan,
                    "status" => $sts
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ]);
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
            "slug" => "required",
            "tambahan" => ""
        ]);
        if ($request->ajax()) {
            // dd($request);
            if ($request->has('tambahan')) {
                $array = $request->tambahan;
            } else {
                $array = [];
            }
            $data =  $this->tableorder($validasiData["slug"], $array);

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
            $tikets = tjual1::where("layanan_id", $slug)->get();

            $data = view("invoice", compact("tjual", "tjual1"))->render();

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
            $pdf = PDF::loadView('download2', compact('tjual', 'tikets'));
            $pdf->setPaper(array(0, 0, 250, 380));
            $tempFilePath = storage_path('app/public/download.pdf');
            $pdf->save($tempFilePath);
            $sendnotif = [
                'title' => 'Pembelian  Berhasil!',
                'subject' => 'Steam App',
                'url' => '',
                'body' => 'Haloo Bapak/ibu , Silahkan download data Tiket Cuci Anda  dibawah: ',
            ];

            Mail::to($tjual->email)->send(new sendMail($sendnotif, $tempFilePath));
            unlink($tempFilePath);
            // return $pdf->stream('download.pdf');
        }
    }
}
