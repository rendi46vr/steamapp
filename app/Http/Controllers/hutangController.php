<?php

namespace App\Http\Controllers;

use App\Http\Requests\pembayaran\request as PembayaranRequest;
use App\Models\Bayar;
use App\Models\Patner;
use App\Tools\tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class hutangController extends Controller
{
    //
    protected $sess = 'searchBayar';
    public function index(){
        // index hutang
        $data = [];
        $data['title'] = "Riwayat Pembayaran" ;

        $data['riwayat'] = $this->tableriwayatbayar(1, false, false,1);
        $data['patners'] = Patner::where('hutang','<>',0)->get();
        try {
            if(Session::has('PatnerID')){
                $data['user'] = Patner::find(Session::get('PatnerID'));
                if(auth()->user()->role != 'Patner'){
                    $data['title'] = "Riwayat Pembayaran ".$data['user']->nama_patner;
                }
            }else{
                $data['user'] = auth()->user()->patner;
            }
        } catch (\Throwable $th) {
            return redirect("/login");
        }

        return view('patner.pembayaran.riwayatpembayaran', $data);
    }

    public function request(){
        // index hutang
        
        $data = [];
        $data['title'] = "Request Bayar" ;
        $data['riwayat'] = $this->tableriwayatbayar(1, false, false,0);
        try {
            if(Session::has('PatnerID')){
                $data['user'] = Patner::find(Session::get('PatnerID'));
            }else{
                $data['user'] = auth()->user()->patner;
            }
        } catch (\Throwable $th) {
            return redirect("/login");
        }
        return view('patner.pembayaran.pembayaran', $data);
    }

    public function tableriwayatbayar($page = 1, $search = false, $ajax = true, $status = null){
        // tabel rwayat hutang

        $riwayat = Bayar::with('patner')->where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('noref', 'like', '%' . $datasearch . '%')
                    ->orwhere('tgl', 'like', '%' . $datasearch . '%')
                    ->orwhere('ket', 'like', '%' . $datasearch . '%')
                    ->orwhere('jumlah', 'like', '%' . $datasearch . '%');
            }
        });
        if($status !== null){
            $riwayat = $riwayat->where('status', $status);
        }
        if(Session::has('PatnerID')){
            $patnerID = Session::get('PatnerID');
            if($status == 0 && auth()->user()->role != 'Patner'){
            }else{
                $riwayat = $riwayat->where('patner_id', $patnerID);
            }
        }else{
            if(auth()->user()->role == 'Patner'){
                $riwayat = $riwayat->where('patner_id', auth()->user()->patner_id);
            }else{
                $riwayat = $riwayat->where('patner_id', '!=' , null);
                
            }
        }


        $riwayat =$riwayat->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($riwayat->lastPage(), $page, 'pagepembayaran');
        $data =  view("patner.pembayaran.tablepembayaran", compact("riwayat", "pagination","status"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "success" => true,
            "parent" => ".dataPembayaran",
            "data" => $data
        ]);

        return view('patner.hutang.tableriwayatbayar');

    }

    public function requestbayar(Request $request){
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            // Define your validation rules here
            'jumlah' => 'required|numeric',
            'norek' => 'nullable|max:100',
            'bank' => 'nullable|max:100',
            'atas_nama' => 'nullable|max:100',
            'bukti' => 'file|mimes:jpg,png,pdf|max:6048',
            'ket' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 200);
        }

        // Process the validated data
        // Example: Save the file
        if ($request->hasFile('bukti')) {
            $filePath = $request->file('bukti')->store('bukti');
        }
        if(auth()->user()->role == "Patner"){
            $patner = auth()->user()->patner;
        }else{
            $patner = Patner::find($request->input('patner_id'));
        }

        $bayar = new Bayar();
        $bayar->norek = $request->input('norek');
        $bayar->jumlah = $request->input('jumlah');
        $bayar->bank = $request->input('bank');
        $bayar->atas_nama = $request->input('atas_nama');
        $bayar->bukti = $filePath ?? null; // Assuming $filePath is set if file was uploaded
        $bayar->ket = $request->input('ket');
        $bayar->hutang_saat_bayar = $patner->hutang;
        $bayar->patner_id = $patner->id;
        if(auth()->user()->role != "Patner"){
            $bayar->status = 1;
        }
        $bayar->save();
        
        
        $patner->hutang -= $request->input('jumlah');
        $patner->save();
        //send push notification
        if(auth()->user()->role == "Patner"){
            $notif = new NotifController();
            $notif->NotifPengajuanPembayaran($bayar->id);
        }else{
            return $this->tableriwayatbayar(1, false, true,1);

        }
        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully',
            // Add other data to the response if needed
        ]);
    }

    public function batal($id){
        $bayar = Bayar::find($id);
        if($bayar){
            $bayar->status = -2;
            $bayar->save();
        }
        return $this->tableriwayatbayar(1, false, true,0);
    }

    
    public function pagepembayaran($page)
    {
        if (!is_numeric($page)) {
            return $this->tabletorder(1);
        }
        if (Session::has($this->sess)) {
            return $this->tableriwayatbayar(1, true, true,1);
        } else {
            return $this->tableriwayatbayar($page, false, true,1);
        }
    }
    public function searchpembayaran(Request $request)
    {
        Session::put($this->sess, $request->all());
        return  $this->tableriwayatbayar(1, true, true,1);
    }


    public function rinciantransaksi($patner =null){
        $data = [];
        $data['title'] = "Rincian Transaksi";
        if(auth()->user()->role == "Patner"){
            $patner = Patner::with('bayar','tjual')->find(auth()->user()->patner_id);
        }else{
            Session::put('PatnerID', $patner);
            $patner = Patner::with('bayar','tjual')->find($patner);
        }
        //ambil total transaksi dan total nominalnya berdasarkan kolom totalbayar di tjuals berhasil dari relasi tjual
        $data['total_order_berhasil'] = $patner->tjual->where('status', 'berhasil')->count();
        $total_nominal = $patner->tjual->where('status', 'berhasil')->sum('totalbayar');
        $data['total_nominal'] = tools::rupiah($total_nominal);
        $data['total_pembayaran'] = $patner->bayar->count();
        $total_nominal_bayar =$patner->bayar->sum('jumlah');
        $data['total_nominal_bayar'] = tools::rupiah($total_nominal_bayar);
        $data['sisa_hutang'] = tools::rupiah($total_nominal - $total_nominal_bayar);
        $data['patner'] = $patner;
        return view('patner.pembayaran.rincianhutang', $data);
    }


    public function setuju(Request $request,$id){
        $bayar = Bayar::find($id);
        if($bayar){
            $bayar->status = $request->status;
            $bayar->save();
            $patner = Patner::find($bayar->patner_id);
            $patner->hutang -= $bayar->jumlah;
            $patner->save();
        }
        //send notif persetujuan pembayaran
        $notif = new NotifController();
        if($request->status > 0){
            $notif->NotifPembayaranDisetujui($bayar->id);
        }else{
            $notif->NotifPembayaranDitolak($bayar->id);
        }
        
        return $this->tableriwayatbayar(1, false, true,0);
    }

    public function inputBayar(){
        // index hutang
        
        $data = [];
        $data['title'] = "Request Bayar" ;
        $data['riwayat'] = $this->tableriwayatbayar(1, false, false,0);
        try {
            if(Session::has('PatnerID')){
                $data['user'] = Patner::find(Session::get('PatnerID'));
            }else{
                $data['user'] = auth()->user()->patner;
            }
        } catch (\Throwable $th) {
            return redirect("/login");
        }
        return view('patner.pembayaran.pembayaran', $data);
    }
}
