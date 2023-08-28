<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tiket;
use App\Models\tjual;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DiskonController;
use Illuminate\Support\Carbon;

use App\Models\layanan;

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
        $layanan = layanan::all();
        return view('index', compact('layanan'));
    }
    public function formorder($slug)
    {

        return view('order.form-order');
    }
    public function order(Request $request, DiskonController $ds)
    {
        $validasiData = $request->validate([
            'name' => 'required',
            'tgl' => '',
            'wa' => 'required:max:60',
            'email' => 'required:email:dns',
            "jenis_kendaraan" => "required",
            "plat" => "required"
        ]);

        return $request;

        $data = tjual::create($validasiData);
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
}
