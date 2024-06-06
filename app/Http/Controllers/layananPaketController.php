<?php

namespace App\Http\Controllers;

use App\Http\Requests\layanan\paket\addpaket;
use App\Http\Requests\layanan\paket\editpaket;
use App\Models\layanan;
use Illuminate\Http\Request;
use App\Tools\tools;
use App\Models\layananPaket;
use LayananPaket as GlobalLayananPaket;

class layananPaketController extends Controller
{
    //
    protected $sess ='searchPaket';

    public function index($id){
        $data= [];
        $data['layanan'] = layanan::find($id);
        $data['title'] = "Detail Paket - ".$data['layanan']->layanan;
        $data['paket'] = $this->tablepaket(1, false, false);
        return view('layanan.paket.index',$data);
    }

    public  function tablepaket($page = 1, $search = false, $ajax = true)
    {
        $paket = LayananPaket::where(function ($e) use ($search) {
            if ($search) {
                $datasearch =  htmlspecialchars(session($this->sess)['search']);
                $e->where('nama_paket', 'like', '%' . $datasearch . '%');
            }
        })->orderby('created_at', 'desc')->paginate(20, ['*'], null, $page);
        $pagination = tools::ApiPagination($paket->lastPage(), $page, 'pagelayanan');
        $data =  view("layanan.paket.tablepaket", compact("paket", "pagination"))->render();

        if (!$ajax) {
            return $data;
        }
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $data
        ]);

    }
    public function  addpaket(addpaket $request){
        
       $data =$request->all();
       LayananPaket::create($data);
        return $this->tablepaket();
    }

    public function editpaket(editpaket $requset){
        $paket = layananPaket::find($requset->id);
        $paket->update($requset->all());
        return $this->tablepaket();
    }

    public function dellayanan($id)
    {
        try {
            layananPaket::destroy($id);
        } catch (\Throwable $th) {
        }
        $layanan = $this->tablelayanan(1, false, false);
        return response()->json([
            "parent" => ".dataTiket",
            "data" => $layanan
        ]);
    }
}
