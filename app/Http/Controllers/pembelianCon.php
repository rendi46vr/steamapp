<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
use App\Models\tjual;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DiskonController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\layanan;
use App\Models\payget;
use App\Models\payments;
use App\Models\tjual1;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $noref = "NOREF" . date("YmdHis");
        //        dd([$product,$qty]);
        if ($validasiData["metpem"] == "tunai") {
            $order = tjual::create([
                "id" => Str::uuid(),
                "metpem" => $metode->channel_code,
                "name" => null,
                "np" => $noref,
                "wa" => "089811982121",
                "email" => $validasiData["email"],
                "tgl" => date("Y-m-d"),
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => $validasiData["plat"]

            ]);
            if ($tambahan) {
                foreach ($getProduct as $l) {
                    tjual1::create([
                        "id" => Str::uuid(),
                        "tjual_id" => $order->id,
                        "layanan_id" => $l->id,
                        "harga" => $l->harga,
                        "name" => $l->layanan
                    ]);
                }
            } else {
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "name" => $main->layanan
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
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => $validasiData["plat"]

            ]);
            if ($tambahan) {
                foreach ($getProduct as $l) {
                    tjual1::create([
                        "id" => Str::uuid(),
                        "tjual_id" => $order->id,
                        "layanan_id" => $l->id,
                        "harga" => $l->harga,
                        "name" => $l->layanan
                    ]);
                }
            } else {
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $main->harga,
                    "name" => $main->layanan
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
        if ($tjual->status == "berhasil") {

            $tikets = tjual1::where("layanan_id", $slug)->get();
            // $pdf = Pdf::loadView('download', compact('tjual', 'tikets'))->setPaper('80mm', '150mm', 'portrait')
            //     ->setWarnings(false);
            // Session::forget('bayar');

            // header('Content-Type: application/json');
            $data = view("invoice", compact("tjual"))->render();

            return $data;

            //     $tikets = tjual1::where("layanan_id", $slug)->get();
            //     $pdf = Pdf::loadView('download', compact('tjual', 'tikets'))->setPaper('80mm', '150mm', 'portrait')
            //         ->setWarnings(false);
            //     Session::forget('bayar');
            //     return $pdfContent = $pdf->stream();
            //     return $pdf;
            //     $pdfFilename = 'hasil-pembayaran.pdf';
            //     file_put_contents($pdfFilename, $pdfContent);
            //     header('Content-Type: application/json');
            //     echo json_encode($pdfContent);
            // } else {
        } else {
            return "ok";
        }
    }
}
