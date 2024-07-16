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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PlatGratisController;
use App\Models\LayananPatner;
use App\Models\logwa;
use App\Models\Patner;
use App\Models\PlatGratis;
use App\Models\TjualPaket;
use Illuminate\Support\Facades\DB;

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
        if (Auth::check() && Auth::user()->role == "Patner") {
            $getId = LayananPatner::with('layanan')->where('patner_id', Auth::user()->patner_id)->pluck('layanan_id')->toArray();
            $layanan = Layanan::whereIn('id', $getId)->where('isaktif', 1)->get();
        } else {
            $layanan = Layanan::where('isaktif', 1)->get();
        }
        return view('index', compact('layanan'));
    }
    public function formorder($slug)
    {
        Session::forget('cqty');
        Session::forget('paket_id');
        $data = [];
        $data['slug']= $slug;
        $data['payment'] = payget::where("status", 1)->get();

        try {
            $data['layanan']= $this->tableorder($slug);
            Session(["order" => $slug]);
            $data['tambahan'] = layanan::get();
            $data['jasa'] = layanan::where("slug", $slug)->first();
            $data['lb'] = layanantambahan::where("isaktif", 1)->get();
            if(auth()->user()){
                if(auth()->user()->role == "Patner"){
                    $data['patner'] = Patner::find(auth()->user()->patner_id);
                }
            }
            // dd($jasa);
            return view('order.form-order', $data);
        } catch (\Throwable $th) {
            return redirect("/");
        }
    }

    public function tableorder($slug, $layanan_tambahan = [], $gratis = false)
    {
        $layanan = layanan::where("slug", $slug)->first();
        $paket = false;
        if($layanan->type == 1){
            $paket = true;
        }
        array_push($layanan_tambahan, $layanan->id);
        $tambahan = layanantambahan::wherein("id", $layanan_tambahan)->get();
        return view('order.table-order', compact("tambahan", "layanan", 'gratis'))->render();
    }
    public function addpaket($id){
        session(['paket_id'=>$id]);
        return $this->tableorder(session('order'));
    }
    public function cqty(Request $request)
    {

        is_numeric($request->qty) ? $qty = $request->qty : $qty = 1;
        Session(["cqty" => $qty]);
        is_array(($request->tambahan)) ? $array = $request->tambahan : $array = [];
        $data = $this->tableorder(session("order"), $array);
        return response()->json(["data" => $data]);
    }

    public function order(Request $request, ipaymuController $ip)
    {
        // DB::transaction();
        // try {
        $validasiData = $request->validate([
            'tgl' => '',
            'wa' => 'required|numeric',
            'email' => 'email:dns',
            "plat" => "required",
            "metpem" => "required",
            "quantity" => "max:2",
            "durasi" => "max:2",
        ]);
        if(!$request->has('email')){
            $validasiData['email'] = 'smartwax@gmail.com';
        }
        $getplat = new PlatGratisController();
        $platgratis = $getplat->dataPlatgratis();
        $gratis = false;
        if(in_array(strtoupper($validasiData['plat']), $platgratis)){
            $gratis = true;
        }

        $lastRecord = tjual::latest()->first();
        $main = layanan::where("slug", Session("order"))->first();
        $getlayanan = $main->layanan();
        if (strtoupper($validasiData["plat"]) == $lastRecord->plat) {
            $createdAt = Carbon::parse($lastRecord->created_at);
            $now = Carbon::now();
            if ($createdAt->diffInMinutes($now) < 3) {
                return response()->json([
                    "success" => true,
                    "data" => url("payment/" . $lastRecord->id)
                ]);
            }
        }
        $opsiqty = 1;
        // add on bisa tambah
        $opsistring = " ";
        if ($main->formqty > 0) {
            if ($request->has('quantity')) {
                if ($request->quantity > 0) {
                    $opsiqty = $request->quantity;
                    $opsistring = " ($opsiqty X)";
                }
            }
        }
        // jika tipe paket
        if($main->type == 1){
            $opsistring= " (".$getlayanan->paket." )";
        }

        $metode = payget::where("channel_code", $validasiData["metpem"])->first();
        $tambahan = false;
        $lt = [];
        $lt[] = $main->id;
        //cek sip

        $jam = Carbon::now()->format('Y-m-d H:i:s');
        $sip = null; // Inisialisasi variabel $sip
        $waktu = Carbon::parse($jam);
        if ($waktu->isBetween('7:00', '14:31')) {
            $sip = '0';
        } elseif ($waktu->isBetween('14:31', '23:59')) {
            $sip = '1';
        }
        $patner = false;
        $patnerId = null;
        if (auth()->user()) {
            if (auth()->user()->sip == "3") {
                if ($waktu->isBetween('11:00', '20:00')) {
                    $sip = '3';
                }
            }
            //kondisi patner true maka sistem pembayran ke hutang
            if(auth()->user()->role == "Patner"){
                $patner = true;
                $patnerId= auth()->user()->patner_id;
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
            // $qtyoption =   $getProduct->pluck("qtyoption")->toArray();
            $count = count($product);
            $qty = [];
            for ($i = 1; $i < $count; $i++) {
                array_push($qty, 1);
            }
            $harga =   $getProduct->pluck("harga")->toArray();
            array_push($harga, $getlayanan->harga * $opsiqty);
            if ($gratis) {
                $jumlah_harga = count($harga);
                for ($i = 0; $i < $jumlah_harga; $i++) {
                    $harga[$i] = 0;
                }
            }
            if($gratis){

                $amount = 0;
            }else{
                $amount = ($getProduct->sum("harga") - $getProduct->sum("diskon")) + ($getlayanan->harga * $opsiqty - $getlayanan->diskon * $opsiqty);
            }
        } else {
            $product = [$main->layanan];
            $qty =   [$main->qtyoption];
            $harga =   [($getlayanan->harga * $opsiqty - $getlayanan->diskon * $opsiqty)];
            if($gratis){
                $amount =0;
            }else{
                $amount = ($getlayanan->harga * $opsiqty - $getlayanan->diskon * $opsiqty);
            }
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

        $durasi = 0;
        $start_at = null;
        $end_at = null;
        if($main->type == 1){
            $durasi = $request->durasi;
            $start_at = date('Y-m-d');
            $end_at = date('Y-m-d', strtotime('+'.$request->durasi.' day'));
        }
        if ($validasiData["metpem"] == "tunai") {
            
            $order = tjual::create([
                "id" => Str::uuid(),
                "metpem" => $patner ? "hutang": $metode->channel_code,
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
                "type_layanan" => $getlayanan->type_layanan,
                "start_at" => $getlayanan->start_at,
                "end_at" => $getlayanan->end_at,
                "durasi" => $getlayanan->durasi,
                "sisa_durasi" => $getlayanan->durasi,
                "plat" =>  strtoupper($validasiData["plat"]),
                "user_id" => $userid,
                "sip" => $sip,
                'start_at' =>  $start_at,
                'end_at' =>$end_at,
                "patner_id" => $patnerId
            ]);
            $sts = 0;
            for ($i = 1; $i <= $main->qtyoption; $i++) {
                if (Auth::user()) {
                    $i == 1 ? $sts = 1 :  $sts = 0;
                }
                if($main->type == 1){
                    $i == 1 ? $sts = 0 :'';
                }
                if($patner){
                    $sts = 0;
                }
                if($gratis){
                    $ttharga=0;
                    $ttdiskon =0;
                }else{
                    $ttharga = $getlayanan->harga * $opsiqty;
                    $ttdiskon = $getlayanan->diskon * $opsiqty;
                }
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $ttharga,
                    "diskon" => $ttdiskon,
                    "opsiqty" => $opsiqty,
                    "name" => $main->layanan . $opsistring,
                    "status" => $sts
                ]);
            }
            if ($tambahan) {
                foreach ($getProduct as $gp) {
                    tjual2::create([
                        "id" => Str::uuid(),
                        "tjual_id"  => $order->id,
                        "layanantambahan_id" => $gp->id,
                        "harga" => $gratis ? 0 : $gp->harga,
                        "diskon" => $gratis ? 0 : $gp->diskon
                    ]);
                }
            }
            if($order->type == 1){
                TjualPaket::create([
                    'tjual_id' => $order->id,
                    'start_at' => $order->start_at,
                    'nama_paket' => $order->paket,
                    'end_at' => $order->end_at,
                    'durasi' => $getlayanan->durasi,
                    'status' => 1,
                    'sisa_durasi'=> $getlayanan->durasi,
                    'status' => 1,
                ]);
            }
            if (Auth::user()) {
                $order->input_by = auth()->user()->id;
                $order->save();
            }
            if($patner){
                $dataPatner = Patner::find(auth()->user()->patner_id);
                $this->Qr($order->id, false);
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
                "type_layanan" => $getlayanan->type_layanan,
                "start_at" => $getlayanan->start_at,
                "end_at" => $getlayanan->end_at,
                "durasi" => $getlayanan->durasi,
                "sisa_durasi" => $getlayanan->durasi,
                "totalbayar" => $amount,
                "status" => "pending",
                "jenis_kendaraan" => null,
                "plat" => strtoupper($validasiData["plat"]),
                "user_id" => $userid,
                "sip" => $sip
            ]);
            for ($i = 1; $i <= $main->qtyoption; $i++) {
                $sts = 0;
                if (Auth::user()) {
                    $i == 1 ? $sts = 1 :  $sts = 0;
                }
                if($gratis){
                    $ttharga=0;
                    $ttdiskon =0;
                }else{
                    $ttharga = $getlayanan->harga * $opsiqty;
                    $ttdiskon = $getlayanan->diskon * $opsiqty;
                }
                tjual1::create([
                    "id" => Str::uuid(),
                    "tjual_id" => $order->id,
                    "layanan_id" => $main->id,
                    "harga" => $ttharga,
                    "diskon" => $ttdiskon,
                    "opsiqty" => $opsiqty,
                    "name" => $main->layanan . $opsistring,
                    "status" => $sts
                ]);
            }
            if ($tambahan) {
                foreach ($getProduct as $gp) {

                    tjual2::create([
                        "id" => Str::uuid(),
                        "tjual_id"  => $order->id,
                        "layanantambahan_id" => $gp->id,
                        "harga" => $gratis ? 0 : $gp->harga,
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
        //create if order paket
        if($order->type == 1){
            TjualPaket::create([
                'tjual_id' => $order->id,
                'start_at' => $order->start_at,
                'nama_paket' => $order->paket,
                'end_at' => $order->end_at,
                'durasi' => $getlayanan->durasi,
                'status' => 1,
                'sisa_durasi'=> $getlayanan->durasi,
                'status' => 1,
            ]);
        }
        if (Auth::user()) {
            $order->input_by = auth()->user()->id;
            $order->save();
        }
        // DB::commit();
        return response()->json([
            "success" => true,
            "data" => url("payment/" . $order->id)
        ]);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     throw $th;
        // }
        
        return redirect("payment/" . $order->id);
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
            "tambahan" => "",
            "plat" => ''
        ]);
        if ($request->ajax()) {
            // dd($request);
            if ($request->has('tambahan')) {
                $array = $request->tambahan;
            } else {
                $array = [];
            }
            $gratis = false;
            $getplat = new PlatGratisController();
            $platgratis = $getplat->dataPlatgratis();
            
            if(in_array(strtoupper($validasiData['plat']), $platgratis)){
                $gratis = true;
            }

            $data =  $this->tableorder(session("order"), $array, $gratis);

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
    public function kirirmnota()
    {
        
        return $this->tiketpdf('cd86925b-d545-4e41-b793-d55f7a733c15');
    }
    public function kirimnota($slug)
    {

        $status = $this->sendNotif($slug, true);
        $msg= 'Nota Berhasil Terkirim!';
        if($status){
            $msg = 'Nota Gagal Terkirm!';
        }
        
        return response()->json([
            "success" => $status ,
            'message' => $msg
        ]);
    }
    public function downloadQr($slug){
        return $this->Qr($slug, true);
    }

    public function Qr($slug, $download = false){
        if(!$download){
            try {
                //code...
                $data = Http::get('http://vittindo.my.id/steamapp/Qr/'.$slug);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return true;
        }
        $tjual = tjual::findOrFail($slug);
        $tikets = tjual1::where("tjual_id", $slug)->get();
        $cek = tjual::where(['id'=>$slug, 'type_layanan'=> 1])->first();
        if($cek){
            $tikets = tjual1::where("tjual_id", $slug)->orderBy('created_at','asc')->limit(1)->get();
        }
        $addon = tjual2::where("tjual_id", $tjual->id)->get();        
        $tjual1 = $tikets;
        $patner = Patner::find(auth()->user()->patner_id);
        $pdf = PDF::loadView('download2', compact('tjual', 'tikets','patner'));
        $pdf->setPaper(array(0, 0, 250, 400));
        $tempFilePath = storage_path('app/public/qrcode.pdf');
        if($download){
            return $pdf->download('QrCode Smartwax Palembang.pdf');
        }
        $pdf->save($tempFilePath);
        $qrpdf = file_get_contents($tempFilePath);
        $text1 = "🎟️ QR/Tiket Reservasi Smartwax 🚗\n\n Tiket ini dapat digunakan dalam 24 jam kedepan.\n Silakan serahkan tiket ini kepada kasir Smartwax untuk menikmati layanan pencucian mobil Anda.\n\n Terima kasih!\n SMARTWAX PALEMBANG";


        Http::attach(
            'file',
            $qrpdf,
            'QrCode Smartwax Palembang.pdf'
        )->post(env('WA_URL') . "kirimfile", [
            "idclient" => intval(env('WA_IDCLIENT')),
            "number" => $tjual->wa,
            "pesan" => $text1,

        ]);
    }
    public function sendNotifPartnership($slug){

        // $tjual = tjual::findOrFail($slug);
        // $text1 = "🎟️ QR/Tiket Reservasi Smartwax dengan \n No. Referensi : *".$tjual->np."*, \n No. Kendaraan : *".$tjual->plat."* \n Sudah Terpakai!.\n\n Terima kasih!\n *SMARTWAX PALEMBANG*";
        // $data = Http::post(env('WA_URL') . "kirimpesan", [
        //     "idclient" => intval(env('WA_IDCLIENT')),
        //     "number" => $tjual->wa,
        //     "pesan" => $text1,

        // ]);
       return $data = Http::get('http://vittindo.my.id/steamapp/sendNotifPartnership/'.$slug);

    }

    public function tiketpdf($slug, $true=true)
    {
        $tjual = tjual::findOrFail($slug);
        try {
            //code...
            // $cekwa = logwa::where('wa', $tjual->wa)->first();
            // if($cekwa){
            //     $lastUpdated = Carbon::parse($cekwa->updated_at);
            //     if (Carbon::now()->diffInMinutes($lastUpdated) >= 60) {
            //         $this->sendNotif($slug, true);
            //     }else {
            //         $cekwa->wa = $tjual->wa;
            //         $cekwa->save();
            //     }
            // }
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        if ($tjual->status ==  "berhasil") {

            $tikets = tjual1::where("tjual_id", $slug)->get();
            $cek = tjual::where(['id'=>$slug, 'type_layanan'=> 1])->first();
            if($cek){
                $tikets = tjual1::where("tjual_id", $slug)->orderBy('created_at','asc')->limit(1)->get();
            }
            $addon = tjual2::where("tjual_id", $tjual->id)->get();

            
            $tjual1 = $tikets;
            

            $widthplus = count($tikets) * 22;
            // $addonplus = count($addon) * 22;
            $nota = PDF::loadView("download", compact("tjual", "tjual1", "addon"));
            $nota->setPaper(array(0, 0, 250, 340 + $widthplus ));
            $tempFilePathnota = storage_path('app/public/nota.pdf');
            // return $nota->stream();
            $nota->save($tempFilePathnota);

            $notapdf = file_get_contents($tempFilePathnota);


            $text = "📝 Nota Transaksi Smartwax 🛒\n";
            $encodedText = urlencode($text);
            // $encodedText1 = urlencode($text1);
            // kirim ke wa 
            // Membuka file dan membacanya sebagai string
            if($tjual->qty > 1 || $tjual->type_layanan == 1){
                if($true){
                    //buar qr tiket jika perlu
                    $pdf = PDF::loadView('download2', compact('tjual', 'tikets'));
                    $pdf->setPaper(array(0, 0, 250, 380));
                    $tempFilePath = storage_path('app/public/qrcode'.date('YmdHis').'.pdf');
                    $pdf->save($tempFilePath);
                    $qrpdf = file_get_contents($tempFilePath);
                    $text1 = "🔍Qrcode Pembelian.  \n ";

                    Http::attach(
                        'file',
                        $qrpdf,
                        'QrCode Smartwax Palembang.pdf'
                    )->post(env('WA_URL') . "kirimfile", [
                        "idclient" => intval(env('WA_IDCLIENT')),
                        "number" => $tjual->wa,
                        "pesan" => $text1,
        
                    ]);
                }
            }
            $data = Http::attach(
                    'file',
                    $notapdf,
                    'Nota Smartwax Palembang.pdf'
                )->post(env('WA_URL') . "kirimfile", [
                "idclient" => intval(env('WA_IDCLIENT')),
                "number" => $tjual->wa,
                "pesan" => $text,
            ]);
           
            

            // $sendnotif = [
            //     'title' => 'Pembelian  Berhasil!',
            //     'subject' => 'Steam App',
            //     'url' => '',
            //     'body' => 'Haloo Bapak/ibu , Silahkan download data Tiket Cuci Anda  dibawah: ',
            // ];
            // Mail::to(strtolower($tjual->email))->send(new sendMail($sendnotif, $tempFilePath, $tempFilePathnota));

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
            // dd($pelanggan);
            $isPaket =false;
            $isexpired = true;
            $message = '';
            $slug ="";
            $action = false;
            if($pelanggan){
                $paket = tjual::where(['plat' => $search, 'type_layanan'=>1, 'isaktif'=> 1,'status'=> 'berhasil'])->first();
                if($paket){
                    //cek end_date apakah sudah lewat dari tanggal sekarang 
                    $isPaket =true;
                    $message = "Paket Langganan Terkahir Telah berakhir";
                    if(!Carbon::parse($paket->end_at)->isPast()){
                        $isexpired = false;
                        if(auth()->check()){
                            $action =true;
                        $slug = 'langganan/'.$paket->id;

                            $message="Paket Langganan Masih Tersedia!";
                        }else{
                            $message="Paket Langganan Masih Tersedia. Silahkan datang langsung ke SmartWax untuk pemakaian.";
                        $slug = url('langganan/'.$paket->id);

                        }
                    }
                    $paket->end_date;
                }

            }
            return response()->json([
                "success" => true,
                "wa" => $pelanggan->wa,
                "email" => $pelanggan->email,
                'paket' => $isPaket,
                'expire' => $isexpired,
                'message' => $message,
                "slug" => $slug,
                "action" => $action,

            ]);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                "success" => false,
                "wa" => "",
                "email" => "",
                'paket'=> false,
                "message"=>"",
                "slug"=>"",
                "action" => false,
            ]);
        }
    }

    public function langganan($slug){
        try {
            $langganan = tjual::find($slug);
        } catch (\Throwable $th) {
            return redirect('/');
        }
    }

    public function sendNotif($notif, $true = true){
        try {
            if($true){
                $url = 'http://vittindo.my.id/steamapp/kirimwa/'.$notif;
            }else{
                $url = 'http://vittindo.my.id/steamapp/kirim/'.$notif;
            }
            $data = Http::get($url);
            return true;
        } catch (\Throwable $th) {
        }
        return false;


    }
    public function set(){

    }
}
